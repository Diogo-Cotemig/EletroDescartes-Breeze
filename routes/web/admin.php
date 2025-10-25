<?php

use App\Http\Controllers\Backend\AdminController;
use Illuminate\Support\Facades\Route;

// Rotas de Paginas administrativas
Route::get('admin/dashboard', [AdminController::class, 'dashboard'])
->middleware(['auth', 'admin'])
->name('admin.dashboard');
