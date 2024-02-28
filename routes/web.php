<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('advertisements', AdvertisementController::class)->except(['index', 'show']);
Route::get('/advertisements/{id}', 'AdvertisementController@show')->name('advertisements.show');
Route::post('/advertisements', [AdvertisementController::class, 'store'])->name('advertisements.store');
Route::get('/advertisements/{id}/download', [AdvertisementController::class, 'download'])->name('advertisements.download');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // User Routes
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    // Admin Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
});
