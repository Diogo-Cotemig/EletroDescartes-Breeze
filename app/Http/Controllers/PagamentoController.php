<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagamento;
use App\Models\AgendamentoColeta;

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

        $codigoPix = 'PIX-' . strtoupper(uniqid());

        $pagamento = Pagamento::create([
            'agendamento_id' => $request->agendamento_id,
            'valor' => $request->valor,
            'metodo' => 'pix',
            'status' => 'pendente',
            'codigo_pix' => $codigoPix,
        ]);

        $agendamento = AgendamentoColeta::find($request->agendamento_id);
        $agendamento->status = 'agendado';
        $agendamento->save();

        return redirect()->route('pagamento.sucesso', ['id' => $pagamento->id]);
    }

    /**
     * Tela de sucesso
     */
    public function sucesso($id)
    {
        $pagamento = Pagamento::findOrFail($id);
        return view('tasks.pagamento_sucesso', compact('pagamento'));
    }
}
