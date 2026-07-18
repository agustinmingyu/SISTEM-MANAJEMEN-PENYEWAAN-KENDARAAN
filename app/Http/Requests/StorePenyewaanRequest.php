<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenyewaanRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_sewa' => 'required|date',
            'lama_sewa'    => 'required|integer|min:1',
        ];
    }
}
