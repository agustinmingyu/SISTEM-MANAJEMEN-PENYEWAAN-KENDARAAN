<?php

namespace App\Notifications;

use App\Models\Penyewaan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PenyewaanStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected Penyewaan $penyewaan;
    protected string $statusLama;

    public function __construct(Penyewaan $penyewaan, string $statusLama)
    {
        $this->penyewaan = $penyewaan;
        $this->statusLama = $statusLama;

        // delay singkat agar notifikasi dikirim setelah transaksi DB commit
        $this->delay(now()->addSecond());
    }

    /**
     * Channel notifikasi: email + disimpan di database (untuk lonceng notifikasi).
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $kendaraan = $this->penyewaan->kendaraan;
        $url = route('user.penyewaan.show', $this->penyewaan->id);

        $mail = (new MailMessage)
            ->subject('Status Penyewaan #' . $this->penyewaan->id . ' Diperbarui')
            ->greeting('Halo ' . ($notifiable->name ?? 'Pengguna') . ',');

        if ($this->penyewaan->status === 'Disetujui') {
            $mail->line('Kabar baik! Penyewaan kamu untuk kendaraan "' . ($kendaraan?->nama ?? '-') . '" telah DISETUJUI.')
                 ->line('Tanggal sewa: ' . $this->penyewaan->tanggal_sewa)
                 ->line('Lama sewa: ' . $this->penyewaan->lama_sewa . ' hari')
                 ->line('Total: Rp ' . number_format($this->penyewaan->total_harga, 0, ',', '.'));
        } elseif ($this->penyewaan->status === 'Ditolak') {
            $mail->line('Mohon maaf, penyewaan kamu untuk kendaraan "' . ($kendaraan?->nama ?? '-') . '" telah DITOLAK.')
                 ->line('Silakan hubungi admin untuk informasi lebih lanjut, atau ajukan penyewaan lain.');
        } else {
            $mail->line('Status penyewaan kamu telah diperbarui menjadi: ' . $this->penyewaan->status);
        }

        return $mail->action('Lihat Detail Penyewaan', $url)
                     ->line('Terima kasih telah menggunakan layanan kami.');
    }

    public function toArray($notifiable)
    {
        return [
            'penyewaan_id' => $this->penyewaan->id,
            'kendaraan'    => $this->penyewaan->kendaraan?->nama,
            'status'       => $this->penyewaan->status,
            'status_lama'  => $this->statusLama,
            'message'      => $this->buildMessage(),
        ];
    }

    protected function buildMessage(): string
    {
        $kendaraan = $this->penyewaan->kendaraan?->nama ?? 'kendaraan';

        return match ($this->penyewaan->status) {
            'Disetujui' => "Penyewaan {$kendaraan} kamu telah disetujui.",
            'Ditolak'   => "Penyewaan {$kendaraan} kamu telah ditolak.",
            default     => "Status penyewaan {$kendaraan} kamu diperbarui menjadi {$this->penyewaan->status}.",
        };
    }
}