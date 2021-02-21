<?php

use App\Http\Controllers\Links\Show as ShowLink;
use App\Http\Controllers\Members\Store as StoreMember;
use App\Http\Livewire\Profile\Edit as EditProfile;
use App\Http\Livewire\Boards\Edit as EditBoard;
use App\Http\Livewire\Boards\Index as IndexBoards;
use App\Http\Livewire\Boards\Show as ShowBoard;
use App\Http\Livewire\Home;
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
    Route::get('/boards/{board:id}', ShowBoard::class)->name('boards.show');
    Route::get('/boards/{board:id}/edit', EditBoard::class)->name('boards.edit');

    Route::get('/invitations/{invitation:id}', StoreMember::class)->name('members.store');
    Route::get('/boards/{board:id}/members', IndexMembers::class)->name('members.index');

    Route::get('/links/{link:id}', ShowLink::class)->name('links.show');
    Route::get('/notes/{note:id}', EditNote::class)->name('notes.edit');
    
    Route::get('/search', Search::class)->name('search');
    
    Route::get('/profile', EditProfile::class)->name('profile.edit');
});

require __DIR__ . '/auth.php';
