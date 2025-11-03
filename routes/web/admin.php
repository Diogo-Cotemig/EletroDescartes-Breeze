<?php

use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\AdminController;
use Illuminate\Support\Facades\Route;

// Dashboard do Admin
Route::get('admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

// Perfil do Admin
Route::get('admin/profile', [ProfileController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.profile');

// Atualizar Perfil Admin
Route::post('admin/profile/update', [ProfileController::class, 'update'])
    ->middleware(['auth', 'admin'])
    ->name('admin.profile.update');

Route::get('/tasks.logado', function () {
    return view('tasks.logado');
})->name('tasks.logado');
