<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pembayaran;
use App\Models\Penyewaan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Tampilkan dashboard admin beserta ringkasan statistik.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalPendapatan = Pembayaran::where('status', 'Paid')->sum('amount');
        $pesananPending = Penyewaan::where('status', 'Pending')->count();
        $kendaraanTersedia = Kendaraan::where('status', 'tersedia')->count();

        $transaksiTerbaru = Pembayaran::with(['user', 'penyewaan.kendaraan'])
            ->latest()
            ->take(5)
            ->get();

        // --- Data untuk grafik pendapatan per bulan (6 bulan terakhir) ---
        $pendapatanBulanan = collect(range(5, 0))->map(function ($i) {
            $bulan = now()->subMonths($i);

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

        // --- Data untuk diagram distribusi status penyewaan ---
        $statusPenyewaan = Penyewaan::selectRaw('status, count(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $labelStatus = $statusPenyewaan->keys();
        $dataStatus = $statusPenyewaan->values();

        // --- Data untuk diagram kendaraan paling sering disewa (top 5) ---
        $kendaraanPopuler = Penyewaan::selectRaw('kendaraan_id, count(*) as jumlah')
            ->with('kendaraan:id,nama')
            ->groupBy('kendaraan_id')
            ->orderByDesc('jumlah')
            ->take(5)
            ->get();

        $labelKendaraan = $kendaraanPopuler->map(fn ($k) => $k->kendaraan->nama ?? 'Tidak diketahui');
        $dataKendaraan = $kendaraanPopuler->pluck('jumlah');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPendapatan',
            'pesananPending',
            'kendaraanTersedia',
            'transaksiTerbaru',
            'labelPendapatan',
            'dataPendapatan',
            'labelStatus',
            'dataStatus',
            'labelKendaraan',
            'dataKendaraan',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}