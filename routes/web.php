<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\KendaraanController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\PenyewaanController as AdminPenyewaanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\PenyewaanController;
use App\Http\Controllers\User\KendaraanController as UserKendaraanController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard User
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->middleware([
        'verified',
        'role:user',
    ])
    ->name('dashboard');

    
    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  /*
    |--------------------------------------------------------------------------
    | Notifikasi
    |--------------------------------------------------------------------------
    */

    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifikasi/{id}/baca', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifikasi/tandai-semua', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
  
  
    /*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('role:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        // CRUD Kendaraan
        Route::resource('kendaraan', KendaraanController::class);

        // Menu lainnya
        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::resource('penyewaan', AdminPenyewaanController::class);
        Route::resource('pembayaran', PembayaranController::class);
        Route::get('/riwayat-pembayaran', [PembayaranController::class, 'riwayat'])->name('riwayat-pembayaran.index');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/pengaturan', fn() => view('admin.pengaturan.index'))->name('pengaturan.index');

    });

   /*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('role:user')
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::post('/penyewaan', [PenyewaanController::class, 'store'])
                 ->name('penyewaan.store');

        Route::get('/penyewaan/{penyewaan}/bayar', [PenyewaanController::class, 'bayar'])
                 ->name('penyewaan.bayar');

        Route::post('/penyewaan/{penyewaan}/bayar', [PenyewaanController::class, 'prosesPembayaran'])
                 ->name('penyewaan.prosesPembayaran');
        // ==========================
        // Daftar Kendaraan
        // ==========================
        Route::get('/kendaraan', [userKendaraanController::class, 'index'])
            ->name('kendaraan.index');

        Route::get('/kendaraan/{id}', [userKendaraanController::class, 'show'])
            ->name('kendaraan.show');

        // ==========================
        // Penyewaan
        // ==========================
        Route::get('/penyewaan', [PenyewaanController::class, 'index'])
            ->name('penyewaan.index');

        Route::get('/penyewaan/create', [PenyewaanController::class, 'create'])
            ->name('penyewaan.create');

        Route::post('/penyewaan', [PenyewaanController::class, 'store'])
            ->name('penyewaan.store');

        Route::get('/penyewaan/{penyewaan}', [PenyewaanController::class, 'show'])
            ->name('penyewaan.show');

        Route::get('/penyewaan/{penyewaan}/edit', [PenyewaanController::class, 'edit'])
            ->name('penyewaan.edit');

        Route::put('/penyewaan/{penyewaan}', [PenyewaanController::class, 'update'])
            ->name('penyewaan.update');

        Route::delete('/penyewaan/{penyewaan}', [PenyewaanController::class, 'destroy'])
            ->name('penyewaan.destroy');

    });

    }); // <-- Penutup Route::middleware('auth')->group(function () {

require __DIR__.'/auth.php';

// Webhook endpoint for payment gateway (stub)
use App\Http\Controllers\Webhook\PembayaranWebhookController;
Route::post('/webhook/pembayaran', [PembayaranWebhookController::class, 'handle'])->name('webhook.pembayaran');