<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\KendaraanController;
use App\Http\Controllers\User\PenyewaanController;


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

    Route::get('/dashboard', function () {
        return view('dashboard');
    })
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
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('role:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // CRUD Kendaraan
        Route::resource('kendaraan', KendaraanController::class);

        // Menu lainnya
        Route::get('/penyewaan', fn() => redirect()->route('admin.dashboard'))->name('penyewaan.index');
        Route::get('/pembayaran', fn() => redirect()->route('admin.dashboard'))->name('pembayaran.index');
        Route::get('/riwayat-pembayaran', fn() => redirect()->route('admin.dashboard'))->name('riwayat-pembayaran.index');
        Route::get('/laporan', fn() => redirect()->route('admin.dashboard'))->name('laporan.index');

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

        // Daftar penyewaan user
        Route::get('/penyewaan', [PenyewaanController::class, 'index'])
            ->name('penyewaan.index');

        // Form tambah penyewaan
        Route::get('/penyewaan/create', [PenyewaanController::class, 'create'])
            ->name('penyewaan.create');

        // Simpan penyewaan
        Route::post('/penyewaan', [PenyewaanController::class, 'store'])
            ->name('penyewaan.store');

        // Detail penyewaan
        Route::get('/penyewaan/{penyewaan}', [PenyewaanController::class, 'show'])
            ->name('penyewaan.show');

        // Form edit penyewaan
        Route::get('/penyewaan/{penyewaan}/edit', [PenyewaanController::class, 'edit'])
            ->name('penyewaan.edit');

        // Update penyewaan
        Route::put('/penyewaan/{penyewaan}', [PenyewaanController::class, 'update'])
            ->name('penyewaan.update');

        // Hapus penyewaan
        Route::delete('/penyewaan/{penyewaan}', [PenyewaanController::class, 'destroy'])
            ->name('penyewaan.destroy');

    });

});

require __DIR__.'/auth.php';