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
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\Backend\RotaController;
use App\Http\Controllers\DescarteController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Frontend\ProductRedemptionController;
use App\Http\Controllers\Frontend\HistoricoController;

Route::get('/', function () {
    return view('tasks.index');
});

// ========================================
// ROTAS DE PRODUTOS E HISTÓRICO (AUTENTICADAS)
// ========================================
Route::middleware(['auth'])->group(function () {
    // Produtos para resgate
    Route::get('/produtos', [ProductRedemptionController::class, 'index'])->name('products.index');
    Route::post('/produtos/{product}/resgatar', [ProductRedemptionController::class, 'redeem'])->name('products.redeem');
    
    // Histórico (ÚNICA ROTA - Removida a duplicada)
    Route::get('/historico', [HistoricoController::class, 'index'])->name('historico');
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
// ROTA PARA CLIENTES VEREM ROTAS DE COLETA
Route::get('/descartar', [DescarteController::class, 'index'])->name('descartar');

Route::get('/contato', [ContatoController::class, 'index'])->name('contato');
Route::post('/contato/enviar', [ContatoController::class, 'enviar'])->name('contato.enviar');

Route::get('/OndeDescarte', function () {
    return view('tasks.OndeDescarte');
})->name('OndeDescarte');

// ========================================
// ROTAS DE AGENDAMENTO E PAGAMENTO
// ========================================
Route::post('/agendamento-coleta', [AgendamentoColetaController::class, 'store'])->name('agendamento.store');

Route::post('/salvar-dados-pagamento', function (Request $request) {
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
// ROTAS DE SUPORTE
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
    
    // RESGATES DE PRODUTOS (NOVAS ROTAS)
    Route::get('/products-redemptions', [ProductController::class, 'redemptions'])->name('products.redemptions');
    Route::get('/products-redemptions/{redemption}', [ProductController::class, 'showRedemption'])->name('products.redemptions.show');
    Route::patch('/products-redemptions/{redemption}/status', [ProductController::class, 'updateRedemptionStatus'])->name('products.redemptions.updateStatus');
    Route::delete('/products-redemptions/{redemption}', [ProductController::class, 'destroyRedemption'])->name('products.redemptions.destroy');

    // SUPORTE
    Route::get('/support', [SupportController::class, 'adminIndex'])->name('support.index');
    Route::get('/support/{ticket}', [SupportController::class, 'adminShow'])->name('support.show');
    Route::post('/support/{ticket}/respond', [SupportController::class, 'adminRespond'])->name('support.respond');
    
    // ROTAS DE COLETA
    Route::resource('rotas', RotaController::class);
    
    // Rotas de Pagamentos (Admin)
    Route::resource('payments', PaymentController::class)->only(['index', 'show']);
    Route::patch('payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');
});

require __DIR__.'/auth.php';