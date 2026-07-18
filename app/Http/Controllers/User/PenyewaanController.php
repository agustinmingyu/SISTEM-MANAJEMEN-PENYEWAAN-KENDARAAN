<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Penyewaan;
use Illuminate\Http\Request;
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

        return view('user.penyewaan.create', compact('kendaraans'));
    }

    /**
     * Menyimpan penyewaan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_sewa' => 'required|date',
            'lama_sewa'    => 'required|integer|min:1',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);

        $total = $kendaraan->harga_sewa * $request->lama_sewa;

        Penyewaan::create([
            'user_id'       => Auth::id(),
            'kendaraan_id'  => $request->kendaraan_id,
            'tanggal_sewa'  => $request->tanggal_sewa,
            'lama_sewa'     => $request->lama_sewa,
            'total_harga'   => $total,
            'status'        => 'Pending',
        ]);

        $kendaraan->update([
            'status' => 'disewa',
        ]);

        return redirect()
            ->route('user.penyewaan.index')
            ->with('success', 'Penyewaan berhasil dibuat.');
    }

    /**
     * Detail penyewaan.
     */
    public function show(Penyewaan $penyewaan)
    {
        if ($penyewaan->user_id != Auth::id()) {
            abort(403);
        }

        return view('user.penyewaan.show', compact('penyewaan'));
    }

    /**
     * Form edit penyewaan.
     */
    public function edit(Penyewaan $penyewaan)
    {
        if ($penyewaan->user_id != Auth::id()) {
            abort(403);
        }

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
        if ($penyewaan->user_id != Auth::id()) {
            abort(403);
        }

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
        if ($penyewaan->user_id != Auth::id()) {
            abort(403);
        }

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