<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
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
    Route::get('/groups', [GroupController::class, 'index'])->name('groups');
    Route::post('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups/update', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/delete', [GroupController::class, 'delete'])->name('groups.delete');
});


require __DIR__.'/auth.php';
