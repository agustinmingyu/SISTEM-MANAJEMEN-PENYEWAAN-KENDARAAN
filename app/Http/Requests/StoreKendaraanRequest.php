<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKendaraanRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'nama'         => 'required|string|max:255',
            'merk'         => 'required|string|max:255',
            'plat_nomor'   => 'required|string|max:20|unique:kendaraans,plat_nomor',
            'tahun'        => 'required|integer',
            'harga_sewa'   => 'required|numeric',
            'status'       => 'required|in:tersedia,disewa',
        ];
    }
}
