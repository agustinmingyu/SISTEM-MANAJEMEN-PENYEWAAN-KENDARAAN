<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use App\Models\Kendaraan;
use App\Models\User;
use App\Policies\PenyewaanPolicy;
use App\Policies\PembayaranPolicy;
use App\Policies\KendaraanPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Penyewaan::class => PenyewaanPolicy::class,
        Pembayaran::class => PembayaranPolicy::class,
        Kendaraan::class => KendaraanPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
