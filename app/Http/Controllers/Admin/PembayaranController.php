<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with(['user', 'penyewaan.kendaraan'])->latest()->get();
        $totalPendapatan = $pembayarans->where('status', 'Paid')->sum('amount');

        return view('admin.pembayaran.index', compact('pembayarans', 'totalPendapatan'));
    }
}
