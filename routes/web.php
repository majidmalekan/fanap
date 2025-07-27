<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AuthController as AuthUserController;
use App\Http\Middleware\DetectUserArea;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PollController;
use App\Http\Controllers\PollListController;
use App\Http\Controllers\VoteController;

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.attempt');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| User Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthUserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthUserController::class, 'login'])->name('login.attempt');
Route::get('/logout', [AuthUserController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', IsAdmin::class, DetectUserArea::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('polls', PollController::class)->except(['show']);
    });

/*
|--------------------------------------------------------------------------
| User Poll Voting
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/polls', [PollListController::class, 'index'])->name('polls.list');
    Route::get('/polls/{poll}', [VoteController::class, 'show'])->name('polls.show');
    Route::post('/polls/{poll}', [VoteController::class, 'store'])->name('polls.vote');
});
