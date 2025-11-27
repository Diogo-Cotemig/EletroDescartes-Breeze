<?php
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/logado', function () {
    return view('tasks.logado');
})->name('logado');
// organização das rotas de perfil

Route::middleware('auth')->controller(ProfileController::class)->group(function () {

    Route::get('/profile', 'edit')
    ->name('profile.edit');

    Route::patch('/profile', 'update')
    ->name('profile.update');

    Route::delete('/profile', 'destroy')
    ->name('profile.destroy');

});


// Rota de assistencia (Diogo 29/10)
Route::get('admin/auth', [SupportController::class, 'suport'])
->name('auth.support');
