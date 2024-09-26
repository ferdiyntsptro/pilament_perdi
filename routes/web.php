<?php
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::redirect('/atlg', '/admin/login' )->name('login');
Route::middleware(['auth'])->group(function () {
    Route::get('/produks', ProdukResource::class . '@list')->name('produks.list');
});

// Route::middleware(['role:admin'])->group(function () {
//     Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
// });

// Route::middleware(['web', 'auth', 'admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
//     Route::get('/users', [UserController::class, 'index'])->name('admin.users');
// });


    // Rute Filament untuk UserResource sudah diatur otomatis oleh Filament


