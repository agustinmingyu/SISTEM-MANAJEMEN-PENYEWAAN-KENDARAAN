<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\Penyewaan;

class PembayaranStatusSynchronizer
{
    public function synchronize(Pembayaran $pembayaran): void
    {
        $pembayaran->loadMissing('penyewaan.kendaraan');
        $penyewaan = $pembayaran->penyewaan;

        if (! $penyewaan) {
            return;
        }

        if ($pembayaran->status === 'Paid') {
            $penyewaan->update(['status' => 'Disetujui']);
            $penyewaan->kendaraan?->update(['status' => 'disewa']);

            return;
        }

        $penyewaan->update(['status' => $pembayaran->status === 'Failed' ? 'Ditolak' : 'Pending']);

        $kendaraan = $penyewaan->kendaraan;
        if ($kendaraan && ! Penyewaan::where('kendaraan_id', $kendaraan->id)
            ->where('status', 'Disetujui')->exists()) {
            $kendaraan->update(['status' => 'tersedia']);
        }
    }
}
