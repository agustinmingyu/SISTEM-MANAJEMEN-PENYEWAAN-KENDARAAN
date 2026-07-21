<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Services\PembayaranStatusSynchronizer;
use Illuminate\Http\Request;
use App\Models\Penyewaan;
use Illuminate\Validation\Rule;

class PembayaranController extends Controller
{
   
    public function index()
    {
        $pembayarans = Pembayaran::with(['user', 'penyewaan.kendaraan'])->latest()->get();
        $totalPendapatan = $pembayarans->where('status', 'Paid')->sum('amount');

        return view('admin.pembayaran.index', compact('pembayarans', 'totalPendapatan'));
    }

    /**
     * Riwayat/arsip seluruh transaksi pembayaran, dengan filter status,
     * rentang tanggal, pencarian, dan export CSV.
     */
    public function riwayat(Request $request)
    {
        $query = Pembayaran::with(['user', 'penyewaan.kendaraan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qbuilder) use ($q) {
                $qbuilder->whereHas('user', function ($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%");
                })->orWhereHas('penyewaan.kendaraan', function ($k) use ($q) {
                    $k->where('nama', 'like', "%{$q}%");
                })->orWhere('id', $q);
            });
        }

        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        if ($request->filled('export') && $request->export === 'csv') {
            $rows = $query->latest()->get();

            $filename = 'riwayat_pembayaran_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $columns = ['id', 'user', 'kendaraan', 'jumlah', 'metode', 'status', 'dibayar_pada'];

            $callback = function () use ($rows, $columns) {
                $FH = fopen('php://output', 'w');
                fputcsv($FH, $columns);
                foreach ($rows as $r) {
                    fputcsv($FH, [
                        $r->id,
                        $r->user->name ?? '-',
                        $r->penyewaan->kendaraan->nama ?? '-',
                        $r->amount,
                        $r->payment_method ?? '-',
                        $r->status,
                        optional($r->paid_at)->format('Y-m-d H:i') ?? '-',
                    ]);
                }
                fclose($FH);
            };

            return response()->stream($callback, 200, $headers);
        }

        $totalPendapatan = (clone $query)->where('status', 'Paid')->sum('amount');

        $pembayarans = $query->latest()->paginate(20)->withQueryString();

        return view('admin.riwayat-pembayaran.index', compact('pembayarans', 'totalPendapatan'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['user', 'penyewaan.kendaraan']);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function create()
    {
        $penyewaans = Penyewaan::with('kendaraan')->latest()->get();

        return view('admin.pembayaran.create', compact('penyewaans'));
    }

    public function store(Request $request, PembayaranStatusSynchronizer $statusSynchronizer)
    {
        $data = $request->validate([
            'penyewaan_id' => ['required', 'exists:penyewaans,id', Rule::unique('pembayarans', 'penyewaan_id')],
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
            'status' => 'nullable|string|in:Pending,Paid,Failed',
            'paid_at' => 'nullable|date',
        ]);

        $penyewaan = Penyewaan::findOrFail($data['penyewaan_id']);
        $data['user_id'] = $penyewaan->user_id;
        $data['status'] = $data['status'] ?? 'Pending';
        $data['paid_at'] = ($data['status'] === 'Paid') ? ($data['paid_at'] ?? now()) : null;

        $pembayaran = Pembayaran::create($data);
        $statusSynchronizer->synchronize($pembayaran);

        return redirect()
            ->route('admin.pembayaran.show', $pembayaran)
            ->with('success', 'Pembayaran berhasil dibuat.');
    }

    public function edit(Pembayaran $pembayaran)
    {
        $penyewaans = Penyewaan::with('kendaraan')->latest()->get();

        return view('admin.pembayaran.edit', compact('pembayaran', 'penyewaans'));
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()
            ->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }

    public function update(Request $request, Pembayaran $pembayaran, PembayaranStatusSynchronizer $statusSynchronizer)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Paid,Failed',
            'paid_at' => 'nullable|date',
        ]);

        $pembayaran->update([
            'status' => $request->status,
            'paid_at' => $request->status === 'Paid'
                ? ($request->paid_at ? $request->paid_at : now())
                : null,
        ]);

        $statusSynchronizer->synchronize($pembayaran);

        return redirect()
            ->route('admin.pembayaran.show', $pembayaran)
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}