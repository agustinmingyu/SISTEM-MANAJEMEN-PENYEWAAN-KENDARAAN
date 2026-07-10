<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
// Route::get('/', function () {
//     dd([
//         'check' => auth()->check(),
//         'id' => auth()->id(),
//         'email' => auth()->user()?->email,
//         'role' => auth()->user()?->role,
//     ]);

//     return view('home');
// });
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
    })->middleware([
        'verified',
        'role:user',
    ])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Dashboard Admin
    |--------------------------------------------------------------------------
    */

    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->middleware([
        'role:admin',
    ])->name('admin.dashboard');

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
    | Dummy Routes for Navigation
    |--------------------------------------------------------------------------
    */
    // Admin dummy routes
    Route::get('/admin/kendaraan', fn() => redirect()->route('admin.dashboard'))->name('kendaraan.index');
    Route::get('/admin/penyewaan', fn() => redirect()->route('admin.dashboard'))->name('penyewaan.index');
    Route::get('/admin/pembayaran', fn() => redirect()->route('admin.dashboard'))->name('pembayaran.index');
    Route::get('/admin/riwayat-pembayaran', fn() => redirect()->route('admin.dashboard'))->name('riwayat-pembayaran.index');
    Route::get('/admin/laporan', fn() => redirect()->route('admin.dashboard'))->name('laporan.index');

    // User dummy routes
    Route::get('/user/daftar-kendaraan', fn() => redirect()->route('dashboard'))->name('daftar-kendaraan.index');
    Route::get('/user/penyewaan-kendaraan', fn() => redirect()->route('dashboard'))->name('penyewaan-kendaraan.index');
    Route::get('/user/pembayaran', fn() => redirect()->route('dashboard'))->name('pembayaran.user');
    Route::get('/user/riwayat-penyewaan', fn() => redirect()->route('dashboard'))->name('riwayat-penyewaan.index');
});

require __DIR__.'/auth.php';
