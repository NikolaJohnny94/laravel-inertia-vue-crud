<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::get('/tasks/{id}-{slug}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
