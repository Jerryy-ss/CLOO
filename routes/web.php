<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLoanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/buku/{id}', [CatalogController::class, 'show'])->name('books.show');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('role:peminjam')->name('logout');

Route::middleware('role:peminjam')->group(function () {
    Route::post('/pemesanan', [LoanController::class, 'store'])->name('ordering.store');
    Route::get('/riwayat-peminjaman', [LoanController::class, 'history'])->name('history');
    Route::get('/peminjaman/{id}/barcode', [LoanController::class, 'barcode'])->name('loan.barcode');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.store');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->middleware('role:petugas')->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('role:petugas')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/anggota', [AdminDashboardController::class, 'members'])->name('members');

    Route::get('/buku', [AdminBookController::class, 'index'])->name('books');
    Route::get('/buku/tambah', [AdminBookController::class, 'create'])->name('books.create');
    Route::post('/buku', [AdminBookController::class, 'store'])->name('books.store');
    Route::get('/buku/{id}/edit', [AdminBookController::class, 'edit'])->name('books.edit');
    Route::put('/buku/{id}', [AdminBookController::class, 'update'])->name('books.update');
    Route::delete('/buku/{id}', [AdminBookController::class, 'destroy'])->name('books.destroy');

    Route::get('/permintaan', [AdminLoanController::class, 'requests'])->name('requests');
    Route::post('/permintaan/{id}/setujui', [AdminLoanController::class, 'approve'])->name('requests.approve');
    Route::post('/permintaan/{id}/tolak', [AdminLoanController::class, 'reject'])->name('requests.reject');
    Route::get('/verifikasi-barcode', [AdminLoanController::class, 'verify'])->name('verify');
    Route::post('/verifikasi-barcode/{id}/ambil', [AdminLoanController::class, 'pickup'])->name('verify.pickup');
    Route::get('/status-buku', [AdminLoanController::class, 'status'])->name('status');
    Route::post('/status-buku/{id}/kembali', [AdminLoanController::class, 'returnBook'])->name('status.return');
    Route::get('/jatuh-tempo', [AdminLoanController::class, 'overdue'])->name('overdue');
    Route::get('/riwayat', [AdminLoanController::class, 'history'])->name('history');
});
