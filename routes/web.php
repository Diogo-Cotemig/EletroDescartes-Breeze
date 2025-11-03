<?php
use App\Models\AgendamentoColeta;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\AgendamentoColetaController;

Route::get('/', function () {
    return view('tasks.index');
});

// Rotas de chamados
Route::get('/chamado', [SupportController::class, 'index'])->name('chamado.index');
Route::get('/chamado/criar', [SupportController::class, 'create'])->name('chamado.create');
Route::post('/chamado', [SupportController::class, 'store'])->name('chamado.store');
Route::get('/chamado/{id}', [SupportController::class, 'show'])->name('chamado.show');

Route::get('admin/login',[AdminController::class, 'login'])->name('admin.login');
Route::get('admin/forgot-password',[AdminController::class, 'forgot'])->name('admin.forgot');

// ROTA PARA CLIENTES VEREM PRODUTOS
Route::get('/servicos', [HomeController::class, 'products'])->name('servicos');

Route::get('/contato', function () {
    return view('contato.Index');
})->name('contato');

Route::get('/OndeDescarte', function () {
    return view('tasks.OndeDescarte');
})->name('OndeDescarte');

Route::middleware(['auth'])->get('/historico', [SupportController::class, 'historico'])->name('historico');

Route::get('/descartar', function () {
    return view('tasks.descartar');
})->name('descartar');

// ========================================
// ROTAS DE AGENDAMENTO E PAGAMENTO
// ========================================
Route::post('/agendamento-coleta', [AgendamentoColetaController::class, 'store'])->name('agendamento.store');

Route::post('/salvar-dados-pagamento', function (Request $request) {
    // A função 'session()' armazena dados no lado do servidor, de forma segura.
    session([
        'valor_para_pagamento' => $request->input('valor'),
        'agendamento_id' => $request->input('agendamento_id')
    ]);

    return response()->json(['success' => true]);
});

Route::get('/pagamento', [PagamentoController::class, 'index'])->name('pagamento');
Route::post('/pagamento/store', [PagamentoController::class, 'store'])->name('pagamento.store');

// Tela de sucesso após pagamento
Route::get('/pagamento/sucesso/{id}', [PagamentoController::class, 'sucesso'])->name('pagamento.sucesso');
// Chamando as rotas dos arquivos web/
foreach(File::allFiles(__DIR__.'/web') as $file) {
    require $file->getPathname();
}

// ========================================
// ROTAS DE SUPORTE (Sistema de Tickets)
// ========================================
Route::middleware(['auth'])->group(function () {
    Route::post('/support/create', [SupportController::class, 'store'])->name('support.store');
    Route::get('/meus-chamados', [SupportController::class, 'myTickets'])->name('support.my');
});

// ========================================
// ROTAS ADMIN
// ========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // PRODUTOS
    Route::resource('products', ProductController::class);

    // SUPORTE
    Route::get('/support', [SupportController::class, 'adminIndex'])->name('support.index');
    Route::get('/support/{ticket}', [SupportController::class, 'adminShow'])->name('support.show');
    Route::post('/support/{ticket}/respond', [SupportController::class, 'adminRespond'])->name('support.respond');
});

require __DIR__.'/auth.php';
