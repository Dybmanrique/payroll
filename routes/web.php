<?php

use App\Http\Controllers\AfpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/afps', [AfpController::class, 'index'])->name('afps.index');
    Route::get('/afps/data', [AfpController::class, 'data'])->name('afps.data');
    Route::get('/afps/crear', [AfpController::class, 'create'])->name('afps.create');
    Route::get('/afps/{afp}/editar', [AfpController::class, 'edit'])->name('afps.edit');
    Route::post('/afps/eliminar', [AfpController::class, 'destroy'])->name('afps.destroy');
    
});


require __DIR__.'/auth.php';
