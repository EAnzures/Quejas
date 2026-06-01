<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ComplaintController::class, 'index'])->name('home');
Route::get('/tramite-denuncia', [ComplaintController::class, 'create'])->name('complaints.index');
Route::post('/quejas', [ComplaintController::class, 'store'])->name('complaints.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/quejas', [ComplaintController::class, 'adminIndex'])->name('admin.complaints.index');
    Route::get('/admin/quejas/respondidas', [ComplaintController::class, 'adminAnswered'])->name('admin.complaints.answered');
    Route::post('/admin/quejas/{complaint}/responder', [ComplaintController::class, 'respond'])->name('admin.complaints.respond');
    Route::delete('/admin/quejas/{complaint}', [ComplaintController::class, 'destroy'])->name('admin.complaints.destroy');
});
