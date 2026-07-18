<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::where('status', 'tersedia')->get();

        return view('user.kendaraan.index', compact('kendaraans'));
    }

    public function show($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        return view('user.kendaraan.show', compact('kendaraan'));
    }
}