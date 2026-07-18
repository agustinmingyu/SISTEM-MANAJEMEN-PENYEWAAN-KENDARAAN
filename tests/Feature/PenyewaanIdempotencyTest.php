<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Kendaraan;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use Carbon\Carbon;

class PenyewaanIdempotencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_duplicate_submissions_with_same_idempotency_create_only_one_record()
    {
        $user = User::factory()->create(['role' => 'user']);

        $kendaraan = Kendaraan::create([
            'nama' => 'Test Car',
            'merk' => 'TestBrand',
            'plat_nomor' => 'B 1234 XX',
            'tahun' => 2020,
            'harga_sewa' => 100000,
            'status' => 'tersedia',
        ]);

        $payload = [
            'kendaraan_id' => $kendaraan->id,
            'tanggal_sewa' => Carbon::today()->toDateString(),
            'lama_sewa' => 2,
            'idempotency_key' => 'test-key-123',
        ];

        // First submit
        $this->actingAs($user)
            ->post(route('user.penyewaan.store'), $payload)
            ->assertRedirect(route('user.penyewaan.index'));

        // Second submit with same idempotency key
        $this->actingAs($user)
            ->post(route('user.penyewaan.store'), $payload)
            ->assertRedirect();

        $this->assertEquals(1, Penyewaan::count(), 'Hanya 1 penyewaan harus dibuat');
        $this->assertEquals(1, Pembayaran::count(), 'Hanya 1 pembayaran harus dibuat');

        $p = Pembayaran::first();
        $this->assertEquals('test-key-123', $p->idempotency_key);
    }
}
