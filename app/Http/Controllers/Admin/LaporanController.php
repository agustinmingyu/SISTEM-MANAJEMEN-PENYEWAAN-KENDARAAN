<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pembayaran;
use App\Models\Penyewaan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Tampilkan laporan performa penyewaan & pembayaran, lengkap dengan
     * diagram, untuk rentang tanggal yang bisa difilter.
     */
    public function index(Request $request)
    {
        $dari = $request->filled('dari')
            ? \Carbon\Carbon::parse($request->dari)->startOfDay()
            : now()->subMonths(5)->startOfMonth();

        $sampai = $request->filled('sampai')
            ? \Carbon\Carbon::parse($request->sampai)->endOfDay()
            : now()->endOfDay();

        // --- Kartu ringkasan ---
        $totalPendapatan = Pembayaran::where('status', 'Paid')
            ->whereBetween('paid_at', [$dari, $sampai])
            ->sum('amount');

        $totalPenyewaan = Penyewaan::whereBetween('created_at', [$dari, $sampai])->count();

        $penyewaanSelesai = Penyewaan::where('status', 'Selesai')
            ->whereBetween('created_at', [$dari, $sampai])
            ->count();

        $rataRataTransaksi = Pembayaran::where('status', 'Paid')
            ->whereBetween('paid_at', [$dari, $sampai])
            ->avg('amount');

        // --- Grafik tren pendapatan per bulan dalam rentang terpilih ---
        $bulanMulai = $dari->copy()->startOfMonth();
        $bulanAkhir = $sampai->copy()->startOfMonth();
        $jumlahBulan = $bulanMulai->diffInMonths($bulanAkhir) + 1;

        $pendapatanBulanan = collect(range(0, $jumlahBulan - 1))->map(function ($i) use ($bulanMulai) {
            $bulan = $bulanMulai->copy()->addMonths($i);

            $total = Pembayaran::where('status', 'Paid')
                ->whereYear('paid_at', $bulan->year)
                ->whereMonth('paid_at', $bulan->month)
                ->sum('amount');

            return [
                'label' => $bulan->translatedFormat('M Y'),
                'total' => (float) $total,
            ];
        });

        $labelPendapatan = $pendapatanBulanan->pluck('label');
        $dataPendapatan = $pendapatanBulanan->pluck('total');

        // --- Diagram distribusi status penyewaan pada rentang terpilih ---
        $statusPenyewaan = Penyewaan::whereBetween('created_at', [$dari, $sampai])
            ->selectRaw('status, count(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $labelStatus = $statusPenyewaan->keys();
        $dataStatus = $statusPenyewaan->values();

        // --- Diagram kendaraan paling sering disewa pada rentang terpilih ---
        $kendaraanPopuler = Penyewaan::whereBetween('created_at', [$dari, $sampai])
            ->selectRaw('kendaraan_id, count(*) as jumlah')
            ->with('kendaraan:id,nama')
            ->groupBy('kendaraan_id')
            ->orderByDesc('jumlah')
            ->take(5)
            ->get();

        $labelKendaraan = $kendaraanPopuler->map(fn ($k) => $k->kendaraan->nama ?? 'Tidak diketahui');
        $dataKendaraan = $kendaraanPopuler->pluck('jumlah');

        return view('admin.laporan.index', compact(
            'dari',
            'sampai',
            'totalPendapatan',
            'totalPenyewaan',
            'penyewaanSelesai',
            'rataRataTransaksi',
            'labelPendapatan',
            'dataPendapatan',
            'labelStatus',
            'dataStatus',
            'labelKendaraan',
            'dataKendaraan',
        ));
    }
}