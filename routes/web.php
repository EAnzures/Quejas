<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ComplaintController::class, 'index'])->name('home');

Route::get('/debug-s3', function () {
    $disk = config('filesystems.default');
    $env  = env('FILESYSTEM_DISK', 'NO_DEFINIDO');
    try {
        \Storage::put('test-conexion.txt', 'ok');
        \Storage::delete('test-conexion.txt');
        $conexion = 'OK - conexión S3 exitosa';
    } catch (\Throwable $e) {
        $conexion = 'ERROR: ' . $e->getMessage();
    }
    return "<pre>Disco activo: $disk\nFILESYSTEM_DISK env: $env\nPrueba de subida: $conexion</pre>";
});
Route::get('/tramite-denuncia', [ComplaintController::class, 'create'])->name('complaints.index');
Route::post('/quejas', [ComplaintController::class, 'store'])->name('complaints.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/quejas', [ComplaintController::class, 'adminIndex'])->name('admin.complaints.index');
    Route::post('/admin/quejas/{complaint}/responder', [ComplaintController::class, 'respond'])->name('admin.complaints.respond');
    Route::delete('/admin/quejas/{complaint}', [ComplaintController::class, 'destroy'])->name('admin.complaints.destroy');
});
