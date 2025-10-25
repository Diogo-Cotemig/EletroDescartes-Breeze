<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\VendorController;

Route::get('/', function () {
    return view('tasks.index');
});

// Rotas de chamados - falta criar o resources
Route::get('/chamado', [SupportController::class, 'index'])->name('chamado.index');
Route::get('/chamado/criar', [SupportController::class, 'create'])->name('chamado.create');
Route::post('/chamado', [SupportController::class, 'store'])->name('chamado.store');
Route::get('/chamado/{id}', [SupportController::class, 'show'])->name('chamado.show');

Route::get('admin/login',[AdminController::class, 'login'])->name('admin.login');
// recuperação de senha
Route::get('admin/forgot-password',[AdminController::class, 'forgot'])->name('admin.forgot');



Route::get('/OndeDescarte', function () {
    return view('tasks.OndeDescarte');
})->name('OndeDescarte');
Route::get('/historico', function () {
    return view('tasks.historico');
})->name('historico');

Route::get('/pagamento', function () {
    return view('tasks.pagamento');
})->name('pagamento');

Route::get('/descartar', function () {
    return view('tasks.descartar');
})->name('descartar');

// Chamando as rotas
foreach(File::allFiles(__DIR__.'/web') as $file) {
    require $file->getPathname();
}

require __DIR__.'/auth.php';
