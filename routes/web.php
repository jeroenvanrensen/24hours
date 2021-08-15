<?php

use Illuminate\Support\Facades\Route;

// Home
Route::get('/', App\Http\Livewire\Home::class)->name('home')->middleware('guest');

// Boards
Route::get('/app/', App\Http\Livewire\Boards\Index::class)->middleware(['auth', 'verified'])->name('boards.index');
Route::get('/app/boards/{board:uuid}', App\Http\Livewire\Boards\Show::class)->middleware(['auth', 'verified'])->name('boards.show');
Route::get('/app/boards/{board:uuid}/edit', App\Http\Livewire\Boards\Edit::class)->middleware(['auth', 'verified'])->name('boards.edit');

// Invitations
Route::get('/app/invitations/check', App\Http\Controllers\Invitations\CheckForInvitations::class)->middleware(['auth', 'verified'])->name('invitations.check');
Route::get('/app/invitations/{invitation:uuid}', App\Http\Livewire\Invitations\Show::class)->name('invitations.show');

// Members
Route::get('/app/boards/{board:uuid}/members', App\Http\Livewire\Members\Index::class)->middleware(['auth', 'verified'])->name('members.index');
Route::get('/app/boards/{board:uuid}/members/{membership:uuid}', App\Http\Livewire\Members\Edit::class)->middleware(['auth', 'verified'])->name('members.edit');

// Board items
Route::get('/app/links/{link:uuid}', App\Http\Controllers\Links\Show::class)->middleware(['auth', 'verified'])->name('links.show');
Route::get('/app/notes/{note:uuid}', App\Http\Livewire\Notes\Edit::class)->middleware(['auth', 'verified'])->name('notes.edit');

// Profile
Route::get('/profile', App\Http\Livewire\Profile\Edit::class)->middleware('auth')->name('profile.edit');
Route::get('/profile/password', App\Http\Livewire\Profile\Password::class)->middleware('auth')->name('profile.password');
Route::get('/profile/delete', App\Http\Livewire\Profile\Delete::class)->middleware('auth')->name('profile.delete');

// Standard auth
Route::get('/login', App\Http\Livewire\Auth\Login::class)->middleware('guest')->name('login');
Route::get('/register', App\Http\Livewire\Auth\Register::class)->middleware('guest')->name('register');
Route::post('/logout', App\Http\Controllers\Auth\Logout::class)->name('logout');

// Reset password
Route::get('/forgot-password', App\Http\Livewire\Auth\RequestPasswordLink::class)->middleware('guest')->name('password.request');
Route::get('/reset-password/{token}', App\Http\Livewire\Auth\ResetPassword::class)->middleware('guest')->name('password.reset');

// Confirm password
Route::get('/confirm-password', App\Http\Livewire\Auth\ConfirmPassword::class)->middleware('auth')->name('password.confirm');

// Verify email
Route::get('/verify-email', App\Http\Livewire\Auth\VerifyEmail::class)->middleware('auth')->name('verification.notice');
Route::get('/verify-email/{id}/{hash}', App\Http\Controllers\Auth\VerifyEmailController::class)->middleware('auth')->name('verification.verify');
