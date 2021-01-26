<?php

use App\Http\Livewire\Account\Edit as EditAccount;
use App\Http\Livewire\Boards\Create as CreateBoard;
use App\Http\Livewire\Boards\Index as IndexBoards;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->prefix('app')->group(function () {
    Route::get('/', IndexBoards::class)->name('boards.index');
    Route::get('/boards/new', CreateBoard::class)->name('boards.create');
});

Route::get('/account', EditAccount::class)->name('account.edit')->middleware('auth');

require __DIR__ . '/auth.php';
