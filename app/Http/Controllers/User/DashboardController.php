<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\DashboardController;
use App\Models\Kendaraan;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard pelanggan dengan ringkasan data sewa,
     * pembayaran, dan rekomendasi kendaraan miliknya sendiri.
     */
    public function index()
    {
        $userId = Auth::id();

        // Sewa yang sedang aktif/berjalan (sudah disetujui)
        $sewaAktif = Penyewaan::with('kendaraan')
            ->where('user_id', $userId)
            ->where('status', 'Disetujui')
            ->latest()
            ->get();

        // Total seluruh riwayat penyewaan milik user
        $totalRiwayat = Penyewaan::where('user_id', $userId)->count();

        // Tagihan yang masih menunggu pembayaran
        $tagihanPending = Pembayaran::where('user_id', $userId)
            ->where('status', 'Pending')
            ->get();

        // Total pengeluaran dari pembayaran yang sudah lunas
        $totalPengeluaran = Pembayaran::where('user_id', $userId)
            ->where('status', 'Paid')
            ->sum('amount');

        // Rekomendasi kendaraan yang masih tersedia untuk disewa
        $rekomendasiKendaraan = Kendaraan::where('status', 'tersedia')
            ->inRandomOrder()
            ->take(3)
            ->get();

        // 5 riwayat penyewaan terbaru untuk ditampilkan ringkas
        $riwayatTerbaru = Penyewaan::with(['kendaraan', 'pembayaran'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'sewaAktif',
            'totalRiwayat',
            'tagihanPending',
            'totalPengeluaran',
            'rekomendasiKendaraan',
            'riwayatTerbaru',
        ));
    }
}