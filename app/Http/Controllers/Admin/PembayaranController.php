<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\User;

class PembayaranController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Pembayaran::class, 'pembayaran');
    }
    public function index()
    {
        $pembayarans = Pembayaran::with(['user', 'penyewaan.kendaraan'])->latest()->get();
        $totalPendapatan = $pembayarans->where('status', 'Paid')->sum('amount');

        return view('admin.pembayaran.index', compact('pembayarans', 'totalPendapatan'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['user', 'penyewaan.kendaraan']);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function create()
    {
        $penyewaans = Penyewaan::with('kendaraan')->latest()->get();
        $users = User::orderBy('name')->get();

        return view('admin.pembayaran.create', compact('penyewaans', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'penyewaan_id' => 'required|exists:penyewaans,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
            'status' => 'nullable|string|in:Pending,Paid,Failed',
            'paid_at' => 'nullable|date',
        ]);

        $data['status'] = $data['status'] ?? 'Pending';
        $data['paid_at'] = ($data['status'] === 'Paid') ? ($data['paid_at'] ?? now()) : null;

        $pembayaran = Pembayaran::create($data);

        return redirect()
            ->route('admin.pembayaran.show', $pembayaran)
            ->with('success', 'Pembayaran berhasil dibuat.');
    }

    public function edit(Pembayaran $pembayaran)
    {
        $penyewaans = Penyewaan::with('kendaraan')->latest()->get();
        $users = User::orderBy('name')->get();

        return view('admin.pembayaran.edit', compact('pembayaran', 'penyewaans', 'users'));
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()
            ->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }

    public function update(Request $request, Pembayaran $pembayaran)
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

        return redirect()
            ->route('admin.pembayaran.show', $pembayaran)
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
