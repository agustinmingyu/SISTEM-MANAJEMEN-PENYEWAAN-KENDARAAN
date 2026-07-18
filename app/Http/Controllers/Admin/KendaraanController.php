<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    /**
     * Menampilkan semua data kendaraan.
     */
    public function index()
    {
        $kendaraans = Kendaraan::latest()->get();

        return view('admin.kendaraan.index', compact('kendaraans'));
    }

    /**
     * Menampilkan form tambah kendaraan.
     */
    public function create()
    {
        return view('admin.kendaraan.create');
    }

    /**
     * Menyimpan data kendaraan ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'merk'         => 'required|string|max:255',
            'plat_nomor'   => 'required|string|max:20|unique:kendaraans,plat_nomor',
            'tahun'        => 'required|integer',
            'harga_sewa'   => 'required|numeric',
            'status'       => 'required|in:tersedia,disewa',
        ]);

        Kendaraan::create([
            'nama'         => $request->nama,
            'merk'         => $request->merk,
            'plat_nomor'   => $request->plat_nomor,
            'tahun'        => $request->tahun,
            'harga_sewa'   => $request->harga_sewa,
            'status'       => $request->status,
        ]);

        return redirect()
            ->route('admin.kendaraan.index')
            ->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kendaraan.
     */
    public function show(Kendaraan $kendaraan)
    {
        return view('admin.kendaraan.show', compact('kendaraan'));
    }

    /**
     * Menampilkan form edit kendaraan.
     */
    public function edit(Kendaraan $kendaraan)
    {
        return view('admin.kendaraan.edit', compact('kendaraan'));
    }

    /**
     * Mengupdate data kendaraan.
     */
    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'merk'         => 'required|string|max:255',
            'plat_nomor'   => 'required|string|max:20|unique:kendaraans,plat_nomor,' . $kendaraan->id,
            'tahun'        => 'required|integer',
            'harga_sewa'   => 'required|numeric',
            'status'       => 'required|in:tersedia,disewa',
        ]);

        $kendaraan->update([
            'nama'         => $request->nama,
            'merk'         => $request->merk,
            'plat_nomor'   => $request->plat_nomor,
            'tahun'        => $request->tahun,
            'harga_sewa'   => $request->harga_sewa,
            'status'       => $request->status,
        ]);

        return redirect()
            ->route('admin.kendaraan.index')
            ->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    /**
     * Menghapus data kendaraan.
     */
    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()
            ->route('admin.kendaraan.index')
            ->with('success', 'Data kendaraan berhasil dihapus.');
    }
}

