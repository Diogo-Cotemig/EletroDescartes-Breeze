<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendamentoColeta;

class AgendamentoColetaController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validação dos Dados
        $validatedData = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'itens_descartados' => 'required|string', // String JSON ou CSV de itens
            'observacoes_itens' => 'nullable|string',
            'data_coleta' => 'required|date',
            'periodo_preferencia' => 'required|in:manha,tarde,comercial',
            'distancia_estimada' => 'nullable|string',
        ]);

        // 2. Criação do Agendamento no Banco de Dados
        $agendamento = AgendamentoColeta::create($validatedData);

        // 3. Resposta JSON (Recomendado para formulários via JavaScript/Fetch)
        // Se a solicitação for AJAX/Fetch (que é o que vamos usar)
        return response()->json([
            'message' => 'Agendamento de coleta salvo com sucesso!',
            'agendamento_id' => $agendamento->id
        ], 201);
    }
}
