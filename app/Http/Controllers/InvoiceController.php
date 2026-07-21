<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Cetak invoice PDF untuk sebuah transaksi (penyewaan).
     * Admin bisa mencetak invoice transaksi siapa saja; user hanya miliknya sendiri
     * (otorisasi mengikuti PenyewaanPolicy@view yang sudah ada).
     */
    public function cetak(Penyewaan $penyewaan)
    {
        $this->authorize('view', $penyewaan);

        $penyewaan->loadMissing(['user', 'kendaraan', 'pembayaran']);

        $pdf = Pdf::loadView('invoices.pdf', compact('penyewaan'))
            ->setPaper('a4', 'portrait');

        // stream = tampil di tab browser (bisa langsung Ctrl+P / tombol print/save PDF viewer)
        return $pdf->stream('invoice-penyewaan-' . $penyewaan->id . '.pdf');
    }
}