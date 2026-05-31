<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/guest', [App\Http\Controllers\GuestController::class, 'index'])->name('guest');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

Route::get('/board', [App\Http\Controllers\BoardController::class, 'index'])->name('board');