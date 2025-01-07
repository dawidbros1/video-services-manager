<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupManagerController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\GoogleController;
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
    Route::get('/groups/{id}/show', [GroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups/update', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/delete', [GroupController::class, 'delete'])->name('groups.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/group/manage/{id}', [GroupManagerController::class, 'index'])->name('group-manage');
    Route::post('/group/manage/insert', [GroupManagerController::class, 'insert'])->name('group-manage.insert');
    Route::delete('/group/manage/remove', [GroupManagerController::class, 'remove'])->name('group-manage.remove');
});

Route::middleware('auth')->group(function () {
    Route::get('/google', [GoogleController::class, 'index'])->name('google');
    Route::get('/google/authorization', [GoogleController::class, 'authorization'])->name('google.auth');
});

Route::middleware('auth')->group(function () {
    Route::get('/youtube', [YoutubeController::class, 'index'])->name('youtube');
    Route::get('/youtube/videos/{channelId}', [YoutubeController::class, 'videos'])->name('youtube.videos');
});

require __DIR__.'/auth.php';
