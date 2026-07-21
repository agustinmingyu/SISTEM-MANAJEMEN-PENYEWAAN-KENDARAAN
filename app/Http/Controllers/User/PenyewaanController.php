<?php
namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pembayaran;
use App\Models\Penyewaan;
use App\Models\User;
use App\Notifications\PembayaranTercatat;
use Illuminate\Http\Request;
use App\Http\Requests\StorePenyewaanRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PenyewaanController extends Controller
{
    /**
     * Menampilkan daftar penyewaan milik user.
     */
    public function index()
    {
        $penyewaans = Penyewaan::with('kendaraan')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.penyewaan.index', compact('penyewaans'));
    }

    /**
     * Menampilkan form penyewaan.
     */
    public function create()
    {
        $kendaraans = Kendaraan::where('status', 'tersedia')->get();

        $idempotencyKey = (string) \Str::uuid();
        session(['idempotency_key' => $idempotencyKey]);

        return view('user.penyewaan.create', compact('kendaraans', 'idempotencyKey'));
    }

    /**
     * Menyimpan penyewaan baru.
     */
    public function store(StorePenyewaanRequest $request)
    {

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);

        $idempotencyKey = $request->input('idempotency_key');

        if ($idempotencyKey) {
            $existingPembayaran = Pembayaran::where('idempotency_key', $idempotencyKey)->first();
            if ($existingPembayaran) {
                return redirect()
                    ->route('user.penyewaan.show', $existingPembayaran->penyewaan_id)
                    ->with('info', 'Permintaan sudah diproses.');
            }
        }

        // Cek overlapping booking (status Pending atau Disetujui)
        $start = Carbon::parse($request->tanggal_sewa);
        $end = (clone $start)->addDays($request->lama_sewa - 1);

        $existing = Penyewaan::where('kendaraan_id', $kendaraan->id)
            ->whereIn('status', ['Pending', 'Disetujui'])
            ->get();

        foreach ($existing as $e) {
            $es = Carbon::parse($e->tanggal_sewa);
            $ee = (clone $es)->addDays($e->lama_sewa - 1);

            // overlap if not (existing_end < start or existing_start > end)
            if (! ($ee->lt($start) || $es->gt($end))) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Kendaraan sudah dibooking pada rentang tanggal yang dipilih.');
            }
        }

        $total = $kendaraan->harga_sewa * $request->lama_sewa;

        // Simpan penyewaan dan pembayaran dalam transaksi agar konsisten
        $result = \DB::transaction(function () use ($request, $kendaraan, $total, $idempotencyKey) {
            $penyewaan = Penyewaan::create([
                'user_id'       => Auth::id(),
                'kendaraan_id'  => $request->kendaraan_id,
                'tanggal_sewa'  => $request->tanggal_sewa,
                'lama_sewa'     => $request->lama_sewa,
                'total_harga'   => $total,
                'status'        => 'Pending',
                'idempotency_key' => $idempotencyKey,
            ]);

            // kendaraan status akan diupdate ketika pembayaran terverifikasi (webhook)

            $pembayaran = Pembayaran::create([
                'penyewaan_id'   => $penyewaan->id,
                'user_id'        => Auth::id(),
                'amount'         => $total,
                'status'         => 'Pending',
                'payment_method' => 'Saldo',
                'paid_at'        => null,
                'idempotency_key' => $idempotencyKey,
            ]);

            return compact('penyewaan', 'pembayaran');
        });

        // Ambil hasil transaction
        $penyewaan = $result['penyewaan'];
        $pembayaran = $result['pembayaran'];

        // Log activity: create penyewaan and pembayaran
        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'create_penyewaan',
            'subject_type' => Penyewaan::class,
            'subject_id' => $penyewaan->id,
            'before' => null,
            'after' => json_encode($penyewaan->toArray()),
            'ip' => request()->ip(),
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'create_pembayaran',
            'subject_type' => Pembayaran::class,
            'subject_id' => $pembayaran->id,
            'before' => null,
            'after' => json_encode($pembayaran->toArray()),
            'ip' => request()->ip(),
        ]);

        // Notifikasi akan dikirim ketika pembayaran terverifikasi oleh webhook

        return redirect()
    ->route('user.penyewaan.bayar', $penyewaan)
    ->with('success', 'Penyewaan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    /**
 * Halaman pembayaran user.
 */
public function bayar(Penyewaan $penyewaan)
{
    $this->authorize('view', $penyewaan);

    $pembayaran = Pembayaran::where('penyewaan_id', $penyewaan->id)
        ->firstOrFail();

    return view('user.pembayaran.bayar', compact(
        'penyewaan',
        'pembayaran'
    ));
}

/**
 * Proses pembayaran penyewaan.
 */
public function prosesPembayaran(Penyewaan $penyewaan)
{
    $this->authorize('view', $penyewaan);

    $pembayaran = Pembayaran::where('penyewaan_id', $penyewaan->id)
        ->firstOrFail();

    if ($pembayaran->status === 'Paid') {
        return redirect()
            ->route('user.penyewaan.show', $penyewaan)
            ->with('info', 'Pembayaran sudah dilakukan.');
    }

    DB::transaction(function () use ($pembayaran) {

        $pembayaran->update([
            'status' => 'Paid',
            'paid_at' => now(),
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'pay_pembayaran',
            'subject_type' => Pembayaran::class,
            'subject_id' => $pembayaran->id,
            'before' => null,
            'after' => json_encode($pembayaran->fresh()->toArray()),
            'ip' => request()->ip(),
        ]);
    });

    return redirect()
        ->route('user.penyewaan.show', $penyewaan)
        ->with('success', 'Pembayaran berhasil dilakukan.');
}
    /**
     * Detail penyewaan.
     */
    public function show(Penyewaan $penyewaan)
    {
        $this->authorize('view', $penyewaan);

        return view('user.penyewaan.show', compact('penyewaan'));
    }

    /**
     * Form edit penyewaan.
     */
    public function edit(Penyewaan $penyewaan)
    {
        $this->authorize('update', $penyewaan);

        $kendaraans = Kendaraan::where('status', 'tersedia')
            ->orWhere('id', $penyewaan->kendaraan_id)
            ->get();

        return view('user.penyewaan.edit', compact('penyewaan', 'kendaraans'));
    }

    /**
     * Update penyewaan.
     */
    public function update(Request $request, Penyewaan $penyewaan)
    {
        $this->authorize('update', $penyewaan);

        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_sewa' => 'required|date',
            'lama_sewa'    => 'required|integer|min:1',
        ]);

        // Kembalikan kendaraan lama menjadi tersedia
        if ($penyewaan->kendaraan_id != $request->kendaraan_id) {

            Kendaraan::find($penyewaan->kendaraan_id)
                ?->update([
                    'status' => 'tersedia'
                ]);

            Kendaraan::find($request->kendaraan_id)
                ?->update([
                    'status' => 'disewa'
                ]);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);

        $penyewaan->update([
            'kendaraan_id' => $request->kendaraan_id,
            'tanggal_sewa' => $request->tanggal_sewa,
            'lama_sewa'    => $request->lama_sewa,
            'total_harga'  => $kendaraan->harga_sewa * $request->lama_sewa,
        ]);

        return redirect()
            ->route('user.penyewaan.index')
            ->with('success', 'Penyewaan berhasil diperbarui.');
    }

    /**
     * Hapus penyewaan.
     */
    public function destroy(Penyewaan $penyewaan)
    {
        $this->authorize('delete', $penyewaan);

        $kendaraan = Kendaraan::find($penyewaan->kendaraan_id);

        if ($kendaraan) {
            $kendaraan->update([
                'status' => 'tersedia',
            ]);
        }

        $penyewaan->delete();

        return redirect()
            ->route('user.penyewaan.index')
            ->with('success', 'Penyewaan berhasil dihapus.');
    }
}