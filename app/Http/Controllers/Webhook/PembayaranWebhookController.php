<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Penyewaan;
use App\Models\Kendaraan;
use App\Models\User;
use App\Models\ActivityLog;
use App\Notifications\PembayaranTercatat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PembayaranWebhookController extends Controller
{
    /**
     * Handle incoming payment gateway webhook (stub).
     * Expects JSON: { pembayaran_id, status }
     */
    public function handle(Request $request)
    {
        // Validate webhook signature if configured
        $secret = config('services.payment.webhook_secret') ?? env('PAYMENT_WEBHOOK_SECRET');
        if ($secret) {
            $signature = $request->header('X-Signature') ?? $request->header('signature');
            if (! $signature || ! hash_equals(hash_hmac('sha256', $request->getContent(), $secret), $signature)) {
                return response()->json(['message' => 'Invalid signature'], 403);
            }
        }

        $request->validate([
            'pembayaran_id' => 'sometimes|integer',
            'penyewaan_id' => 'sometimes|integer',
            'status' => 'required|string',
        ]);

        $pembayaran = null;

        if ($request->filled('pembayaran_id')) {
            $pembayaran = Pembayaran::find($request->pembayaran_id);
        }

        if (! $pembayaran && $request->filled('penyewaan_id')) {
            $pembayaran = Pembayaran::where('penyewaan_id', $request->penyewaan_id)->first();
        }

        if (! $pembayaran) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }

        DB::transaction(function () use ($pembayaran, $request) {
            $old = $pembayaran->toArray();

            $pembayaran->status = $request->status;
            if (strtolower($request->status) === 'paid') {
                $pembayaran->paid_at = now();
            }
            $pembayaran->save();

            // Update penyewaan and kendaraan when paid
            if (strtolower($request->status) === 'paid') {
                $penyewaan = Penyewaan::find($pembayaran->penyewaan_id);
                if ($penyewaan) {
                    $penyewaan->status = 'Disetujui';
                    $penyewaan->save();

                    $kendaraan = Kendaraan::find($penyewaan->kendaraan_id);
                    if ($kendaraan) {
                        $kendaraan->update(['status' => 'disewa']);
                    }
                }
            }

            // Log activity
            ActivityLog::create([
                'user_id' => $pembayaran->user_id,
                'action' => 'pembayaran_webhook:'.$request->status,
                'subject_type' => Pembayaran::class,
                'subject_id' => $pembayaran->id,
                'before' => json_encode($old),
                'after' => json_encode($pembayaran->toArray()),
                'ip' => $request->ip(),
            ]);
        });

        // Notify user and admins
        $pembayaran->refresh();
        $user = User::find($pembayaran->user_id);
        if ($user) {
            $user->notify(new PembayaranTercatat($pembayaran));
        }

        User::where('role', 'admin')->get()->each(function ($admin) use ($pembayaran) {
            $admin->notify(new PembayaranTercatat($pembayaran));
        });

        return response()->json(['message' => 'OK']);
    }
}
