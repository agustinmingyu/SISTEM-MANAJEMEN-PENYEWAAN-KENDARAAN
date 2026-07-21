<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Penyewaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatTransaksiController extends Controller
{
    /**
     * Riwayat transaksi (penyewaan + status pembayaran) milik user yang login.
     * Mendukung filter status, rentang tanggal, dan pencarian nama kendaraan.
     */
    public function index(Request $request)
    {
        $query = Penyewaan::with(['kendaraan', 'pembayaran'])
            ->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('kendaraan', function ($k) use ($q) {
                $k->where('nama', 'like', "%{$q}%");
            });
        }

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_sewa', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_sewa', '<=', $request->sampai);
        }

        // Total pengeluaran user dari transaksi yang sudah dibayar (mengikuti filter aktif)
        $totalPengeluaran = (clone $query)
            ->whereHas('pembayaran', fn ($p) => $p->where('status', 'Paid'))
            ->get()
            ->sum(fn ($penyewaan) => $penyewaan->pembayaran->amount ?? 0);

        $penyewaans = $query->latest()->paginate(10)->withQueryString();

        return view('user.riwayat.index', compact('penyewaans', 'totalPengeluaran'));
    }
}