<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Kendaraan;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use Carbon\Carbon;

class PembayaranWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_webhook_marks_pembayaran_paid_and_updates_related_records()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'user']);

        $kendaraan = Kendaraan::create([
            'nama' => 'Webhook Car',
            'merk' => 'BrandX',
            'plat_nomor' => 'B 9999 ZZ',
            'tahun' => 2021,
            'harga_sewa' => 50000,
            'status' => 'tersedia',
        ]);

        $penyewaan = Penyewaan::create([
            'user_id' => $user->id,
            'kendaraan_id' => $kendaraan->id,
            'tanggal_sewa' => Carbon::today()->toDateString(),
            'lama_sewa' => 1,
            'total_harga' => 50000,
            'status' => 'Pending',
        ]);

        $pembayaran = Pembayaran::create([
            'penyewaan_id' => $penyewaan->id,
            'user_id' => $user->id,
            'amount' => 50000,
            'status' => 'Pending',
            'payment_method' => 'Saldo',
        ]);

        // Configure webhook secret used by controller
        $secret = 'test-webhook-secret';
        config(['services.payment.webhook_secret' => $secret]);

        $payload = [
            'pembayaran_id' => $pembayaran->id,
            'status' => 'paid',
        ];

        $payloadJson = json_encode($payload);
        $signature = hash_hmac('sha256', $payloadJson, $secret);

        // Act
        $response = $this->postJson(route('webhook.pembayaran'), $payload, [
            'X-Signature' => $signature,
        ]);

        // Assert
        $response->assertStatus(200);

        $pembayaran->refresh();
        $penyewaan->refresh();
        $kendaraan->refresh();

        $this->assertEquals('paid', strtolower($pembayaran->status));
        $this->assertNotNull($pembayaran->paid_at);
        $this->assertEquals('Disetujui', $penyewaan->status);
        $this->assertEquals('disewa', $kendaraan->status);
    }
}
