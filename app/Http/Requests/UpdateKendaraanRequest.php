<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKendaraanRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules()
    {
        $kendaraanId = $this->route('kendaraan')->id ?? null;

        return [
            'nama'         => 'required|string|max:255',
            'merk'         => 'required|string|max:255',
            'plat_nomor'   => ['required','string','max:20', Rule::unique('kendaraans','plat_nomor')->ignore($kendaraanId)],
            'tahun'        => 'required|integer',
            'harga_sewa'   => 'required|numeric',
            'status'       => 'required|in:tersedia,disewa',
        ];
    }
}
