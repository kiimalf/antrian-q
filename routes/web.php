<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/guest', [App\Http\Controllers\GuestController::class, 'index'])->name('guest');
Route::post('/guest/store', [App\Http\Controllers\GuestController::class, 'store'])->name('guest.store');
Route::get('/guest/tiket/{id}', [App\Http\Controllers\GuestController::class, 'tiket'])->name('guest.tiket');
Route::get('/guest/tiket/{id}/status', [App\Http\Controllers\GuestController::class, 'status'])->name('guest.tiket.status');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/manajemen', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.manajemen');

Route::post('/admin/call-next', [App\Http\Controllers\AdminController::class, 'callNext'])->name('admin.call-next');
Route::post('/admin/recall/{id}', [App\Http\Controllers\AdminController::class, 'recall'])->name('admin.recall');
Route::post('/admin/complete/{id}', [App\Http\Controllers\AdminController::class, 'complete'])->name('admin.complete');
Route::post('/admin/late/{id}', [App\Http\Controllers\AdminController::class, 'late'])->name('admin.late');

Route::get('/sse/antrian', [App\Http\Controllers\AdminController::class, 'stream'])->name('sse.antrian');

Route::get('/board', [App\Http\Controllers\BoardController::class, 'index'])->name('board');