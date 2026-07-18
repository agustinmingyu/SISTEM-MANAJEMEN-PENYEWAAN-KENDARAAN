<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKendaraanRequest;
use App\Http\Requests\UpdateKendaraanRequest;
use Illuminate\Support\Facades\Log;

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
    public function store(StoreKendaraanRequest $request)
    {
        try {
            Kendaraan::create($request->validated());

            return redirect()
                ->route('admin.kendaraan.index')
                ->with('success', 'Data kendaraan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storing kendaraan: '.$e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data kendaraan.');
        }
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
    public function update(UpdateKendaraanRequest $request, Kendaraan $kendaraan)
    {
        try {
            $kendaraan->update($request->validated());

            return redirect()
                ->route('admin.kendaraan.index')
                ->with('success', 'Data kendaraan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating kendaraan: '.$e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data kendaraan.');
        }
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

