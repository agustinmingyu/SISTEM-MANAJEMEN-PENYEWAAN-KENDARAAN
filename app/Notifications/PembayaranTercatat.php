<?php

namespace App\Notifications;

use App\Models\Pembayaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PembayaranTercatat extends Notification implements ShouldQueue
{
    use Queueable;

    // set to a short delay to allow transaction commit when queued
    public ?int $delay = 1;

    protected Pembayaran $pembayaran;

    public function __construct(Pembayaran $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $penyewaan = $this->pembayaran->penyewaan;
        $kendaraan = $penyewaan?->kendaraan;

        $url = $penyewaan
            ? route('admin.penyewaan.show', $penyewaan->id)
            : route('admin.pembayaran.index');

        return (new MailMessage)
            ->subject('Pembayaran Tercatat #' . $this->pembayaran->id)
            ->greeting('Halo ' . ($notifiable->name ?? 'Pengguna') . ',')
            ->line('Pembayaran untuk penyewaan telah tercatat.')
            ->line('Jumlah: Rp ' . number_format($this->pembayaran->amount, 0, ',', '.'))
            ->line('Kendaraan: ' . ($kendaraan?->nama ?? '-'))
            ->action('Lihat Pembayaran', $url)
            ->line('Terima kasih.');
    }

    public function toArray($notifiable)
    {
        return [
            'pembayaran_id' => $this->pembayaran->id,
            'amount' => $this->pembayaran->amount,
            'penyewaan_id' => $this->pembayaran->penyewaan_id,
        ];
    }
}
