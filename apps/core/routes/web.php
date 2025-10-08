<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KonsultanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dass21AssessmentController; // added
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('permission:view-dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Akses user ke daftar konsultan
    Route::get('/konsultan', [KonsultanController::class, 'index'])
        ->name('konsultan.index');

    // Lihat detail konsultan
    Route::get('/konsultan/show/{id}', [KonsultanController::class, 'show'])
        ->name('konsultan.show');

    // DASS-21 Routes
    Route::prefix('dass21')->name('dass21.')->group(function () {
        Route::get('/', [Dass21AssessmentController::class, 'index'])->name('index');
        Route::get('/dass21/intro', [Dass21AssessmentController::class, 'intro'])->name('intro');
        Route::post('/start', [Dass21AssessmentController::class, 'start'])->name('start');
        Route::post('/session/{id}/next', [Dass21AssessmentController::class, 'next'])->name('next');
        Route::get('/session/{id}', [Dass21AssessmentController::class, 'form'])->name('form');
        Route::post('/session/{id}', [Dass21AssessmentController::class, 'submit'])->name('submit');
        Route::get('/session/{id}/result', [Dass21AssessmentController::class, 'result'])->name('result');
    });
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
        ->name('konsultan.edit')
        ->middleware('permission:manajemen-konsultan');

    Route::put('/konsultan/update/{id}', [KonsultanController::class, 'update'])
        ->name('konsultan.update')
        ->middleware('permission:manajemen-konsultan');

    Route::delete('/konsultan/destroy/{id}', [KonsultanController::class, 'destroy'])
        ->name('konsultan.destroy')
        ->middleware('permission:manajemen-konsultan');
});

require __DIR__.'/auth.php';
