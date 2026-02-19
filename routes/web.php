<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/tentang', function () {
    return view('tentang');
})->name('about');

Route::get('/layanan', function () {
    return view('layanan');
})->name('services');

Route::get('/galeri', function () {
    return view('galeri');
})->name('gallery');

Route::get('/tips', [\App\Http\Controllers\TipsController::class, 'index'])->name('tips');

Route::get('/tips/{slug}', [\App\Http\Controllers\TipsController::class, 'show'])->name('tips.detail');

Route::get('/kontak', function () {
    return view('kontak');
})->name('contact');

Route::get('/panduan-aksesibilitas', function () {
    return view('panduan-aksesibilitas');
})->name('accessibility-guide');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Messages
    Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [\App\Http\Controllers\Admin\MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{id}', [\App\Http\Controllers\Admin\MessageController::class, 'destroy'])->name('messages.destroy');
});
