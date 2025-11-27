<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagamento;
use App\Models\AgendamentoColeta;
use Illuminate\Support\Facades\Auth;

class PagamentoController extends Controller
{
    /**
     * Exibe a tela de pagamento (Pix)
     */
    public function index(Request $request)
    {
        $valor = session('valor_para_pagamento');
        $agendamentoId = session('agendamento_id');

        if (!$valor || !$agendamentoId) {
            return redirect('/OndeDescarte')->with('error', 'Dados de pagamento não encontrados.');
        }

        return view('tasks.pagamento', [
            'valor' => $valor,
            'agendamento_id' => $agendamentoId,
        ]);
    }

    /**
     * Salva o pagamento no banco
     */
    public function store(Request $request)
    {
        $request->validate([
            'agendamento_id' => 'required|exists:agendamentos_coleta,id',
            'valor' => 'required|numeric|min:0',
        ]);

        // Busca o agendamento
        $agendamento = AgendamentoColeta::findOrFail($request->agendamento_id);

        // Pega o usuário logado ou do agendamento
        $userId = Auth::id() ?? $agendamento->user_id;

        // Se não tiver usuário no agendamento, atualiza
        if (!$agendamento->user_id && Auth::check()) {
            $agendamento->user_id = Auth::id();
            $agendamento->save();
        }

        $codigoPix = 'PIX-' . strtoupper(uniqid());

        // 👇 AGORA SALVA O USER_ID NO PAGAMENTO
        $pagamento = Pagamento::create([
            'agendamento_id' => $request->agendamento_id,
            'user_id' => $userId,
            'valor' => $request->valor,
            'metodo' => 'pix',
            'status' => 'pendente',
            'codigo_pix' => $codigoPix,
        ]);

        $agendamento->status = 'agendado';
        $agendamento->save();

        return redirect()->route('pagamento.sucesso', ['id' => $pagamento->id]);
    }

    /**
     * Tela de sucesso
     */
    public function sucesso($id)
    {
        $pagamento = Pagamento::with('user')->findOrFail($id);
        return view('tasks.pagamento_sucesso', compact('pagamento'));
    }
}
