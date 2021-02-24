<?php

use App\Http\Controllers\Invitations\CheckForInvitations;
use App\Http\Controllers\Links\Show as ShowLink;
use App\Http\Livewire\Profile\Edit as EditProfile;
use App\Http\Livewire\Boards\Edit as EditBoard;
use App\Http\Livewire\Boards\Index as IndexBoards;
use App\Http\Livewire\Boards\Show as ShowBoard;
use App\Http\Livewire\Home;
use App\Http\Livewire\Invitations\Show as ShowInvitation;
use App\Http\Livewire\Members\Edit as EditMember;
use App\Http\Livewire\Members\Index as IndexMembers;
use App\Http\Livewire\Notes\Edit as EditNote;
use App\Http\Livewire\Search\Search;
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

Route::get('/', Home::class)->name('home')->middleware('guest');

Route::middleware(['auth', 'verified'])->prefix('app')->group(function () {
    Route::get('/', IndexBoards::class)->name('boards.index');
    Route::get('/boards/{board:uuid}', ShowBoard::class)->name('boards.show');
    Route::get('/boards/{board:uuid}/edit', EditBoard::class)->name('boards.edit');

    Route::get('/invitations/check', CheckForInvitations::class)->name('invitations.check');
    Route::get('/invitations/{invitation:uuid}', ShowInvitation::class)->name('invitations.show')->withoutMiddleware(['auth', 'verified']);

    Route::get('/boards/{board:uuid}/members', IndexMembers::class)->name('members.index');
    Route::get('/boards/{board:uuid}/members/{membership:uuid}', EditMember::class)->name('members.edit');

    Route::get('/links/{link:uuid}', ShowLink::class)->name('links.show');
    Route::get('/notes/{note:uuid}', EditNote::class)->name('notes.edit');
    
    Route::get('/search', Search::class)->name('search');
    Route::get('/profile', EditProfile::class)->name('profile.edit');
});

require __DIR__ . '/auth.php';
