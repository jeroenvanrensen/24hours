<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Livewire\Auth\ConfirmPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\RequestPasswordLink;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\VerifyEmail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    
    Route::get('/forgot-password', RequestPasswordLink::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/confirm-password', ConfirmPassword::class)->name('password.confirm');
    
    Route::get('/verify-email', VerifyEmail::class)->name('verification.notice');
    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->name('verification.verify');
});
