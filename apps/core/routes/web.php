<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KonsultanController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dass21AssessmentController;
use App\Http\Controllers\Dass21ItemController;
use App\Http\Controllers\PenangananController;
use App\Http\Controllers\Admin\PenangananStepController;
use App\Http\Controllers\SuaraController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('permission:view-dashboard');

    Route::get('/user/edit', [ProfileController::class, 'edit'])->name('user.edit');
    Route::patch('/user/update', [ProfileController::class, 'update'])->name('user.update');
    Route::delete('/user/photo', [ProfileController::class, 'deletePhoto'])->name('user.delete_photo');
    Route::delete('/user', [ProfileController::class, 'destroy'])->name('user.destroy');

    // Akses user ke daftar konsultan
    Route::get('/konsultan', [KonsultanController::class, 'index'])
        ->name('konsultan.index');
    Route::get('/riwayat-konsultasi', [KonsultanController::class, 'riwayat'])->name('konsultan.riwayat');
    Route::get('/pemesanan-konsultasi', [KonsultanController::class, 'pemesanan'])
        ->name('konsultan.pemesanan');
    Route::get('/konsultan/{id}', [KonsultanController::class, 'detail'])
        ->whereNumber('id')
        ->name('konsultan.detail');
    // Halaman QR (tampilkan)
    Route::get('/konsultan/{id}/bayar', [KonsultanController::class, 'qris'])
        ->name('konsultan.bayar.qris');

    // Endpoint polling status (diperlukan oleh pembayaran.blade.php)
    Route::get('/konsultan/bayar/status', [KonsultanController::class, 'qrisStatus'])
        ->name('konsultan.bayar.qris.status');

    // Endpoint konfirmasi ketika QR di-scan (opsional, jika dipakai)
    Route::get('/konsultan/confirm/{sid}', [KonsultanController::class, 'confirmByScan'])
        ->name('konsultan.bayar.confirm');

    // Halaman sukses
    Route::get('/konsultan/bayar/sukses', [KonsultanController::class, 'qrisSukses'])
        ->name('konsultan.bayar.sukses');
    Route::post('/konsultan/{id}/pembayaran', [KonsultanController::class, 'pembayaran'])
        ->whereNumber('id')
        ->name('konsultan.pembayaran');

    // Lihat detail konsultan
    Route::get('/konsultan/show/{id}', [KonsultanController::class, 'show'])
        ->whereNumber('id')
        ->name('konsultan.show');

    // DASS-21 Routes
    Route::prefix('dass21')->name('dass21.')->group(function () {
        Route::get('/', [Dass21AssessmentController::class, 'index'])->name('index');
        Route::get('/dass21/intro', [Dass21AssessmentController::class, 'intro'])->name('intro');
        Route::post('/start', [Dass21AssessmentController::class, 'start'])->name('start');
        Route::post('/session/{id}/next', [Dass21AssessmentController::class, 'next'])->name('next');
        Route::get('/session/{id}', [Dass21AssessmentController::class, 'form'])->name('form');
        Route::post('/session/{id}', [Dass21AssessmentController::class, 'submit'])->name('submit');
        Route::get('/session/{id}/curhat-intro', [Dass21AssessmentController::class, 'curhatIntro'])->name('curhatIntro');
        Route::get('/session/{id}/curhat', [Dass21AssessmentController::class, 'curhat'])->name('curhat');
        Route::get('/session/{id}/curhat-done', [Dass21AssessmentController::class, 'curhatDone'])->name('curhat.done');

        Route::post('/session/{id}/save', [Dass21AssessmentController::class, 'saveTranscript'])->name('curhat.save');

        Route::get('/session/{id}/result', [Dass21AssessmentController::class, 'result'])->name('result');
    });

    Route::post('/suara', [SuaraController::class, 'store'])->name('suara.store');
    Route::post('/suara/{suara}/transcribe', [SuaraController::class, 'transcribe'])->name('suara.transcribe');

    Route::get('/premium', [PremiumController::class, 'index'])->name('premium.index');

    Route::get('/user', [ProfileController::class, 'index'])->name('user.index');

    // Public (authenticated) penanganan detail
    Route::get('/penanganan/{slug}', [PenangananController::class,'showPublic'])->name('penanganan.show');
});

// =========================================================
// 🔐 ROUTE UNTUK USER BIASA (role: user)
// =========================================================
Route::middleware(['auth', 'role:user'])->group(function () {

});

// =========================================================
// 🧭 ROUTE UNTUK ADMIN (role: admin)
// =========================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Manajemen konsultan
    Route::get('/konsultan/create', [KonsultanController::class, 'create'])
        ->name('konsultan.create')
        ->middleware('permission:manajemen-konsultan');

    Route::post('/konsultan/store', [KonsultanController::class, 'store'])
        ->name('konsultan.store')
        ->middleware('permission:manajemen-konsultan');

    Route::get('/konsultan/edit/{id}', [KonsultanController::class, 'edit'])
        ->whereNumber('id')
        ->name('konsultan.edit')
        ->middleware('permission:manajemen-konsultan');

    Route::put('/konsultan/update/{id}', [KonsultanController::class, 'update'])
        ->whereNumber('id')
        ->name('konsultan.update')
        ->middleware('permission:manajemen-konsultan');

    Route::delete('/konsultan/destroy/{id}', [KonsultanController::class, 'destroy'])
        ->whereNumber('id')
        ->name('konsultan.destroy')
        ->middleware('permission:manajemen-konsultan');

    // Manajemen DASS-21 Items (CMS)
    Route::middleware('permission:manajemen-curhat')->prefix('admin/dass21/items')->name('admin.dass21-items.')->group(function () {
        Route::get('/', [Dass21ItemController::class, 'index'])->name('index');
        Route::get('/create', [Dass21ItemController::class, 'create'])->name('create');
        Route::post('/', [Dass21ItemController::class, 'store'])->name('store');
        Route::get('/{dass21_item}/edit', [Dass21ItemController::class, 'edit'])->name('edit');
        Route::put('/{dass21_item}', [Dass21ItemController::class, 'update'])->name('update');
        Route::delete('/{dass21_item}', [Dass21ItemController::class, 'destroy'])->name('destroy');
    });

    // CMS Penanganan
    Route::middleware('permission:manajemen-curhat')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('penanganan', PenangananController::class)->except(['show']);
        // Nested steps management
        Route::prefix('penanganan/{penanganan}')->name('penanganan.steps.')->group(function () {
            Route::get('steps', [PenangananStepController::class,'index'])->name('index');
            Route::get('steps/create', [PenangananStepController::class,'create'])->name('create');
            Route::post('steps', [PenangananStepController::class,'store'])->name('store');
            Route::get('steps/{step}/edit', [PenangananStepController::class,'edit'])->name('edit');
            Route::put('steps/{step}', [PenangananStepController::class,'update'])->name('update');
            Route::delete('steps/{step}', [PenangananStepController::class,'destroy'])->name('destroy');
            Route::post('steps/reorder', [PenangananStepController::class,'reorder'])->name('reorder');
        });
    });
});

require __DIR__.'/auth.php';
