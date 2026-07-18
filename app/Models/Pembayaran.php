<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyewaan_id',
        'user_id',
        'amount',
        'status',
        'payment_method',
        'paid_at',
        'idempotency_key',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
