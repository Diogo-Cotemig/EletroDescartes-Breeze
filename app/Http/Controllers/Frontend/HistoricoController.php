<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\ProductRedemption;
use App\Models\AgendamentoColeta;
use Illuminate\Support\Facades\Auth;

class HistoricoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Busca todos os agendamentos/descartes do usuário
        $agendamentos = AgendamentoColeta::where('user_id', $user->id)
            ->with('pagamento') // Carrega o relacionamento com pagamento
            ->orderBy('created_at', 'desc')
            ->get();

        // Descartes em andamento (status: pendente, confirmado, em_andamento)
        $agendamentosAndamento = AgendamentoColeta::where('user_id', $user->id)
            ->whereIn('status', ['pendente', 'confirmado', 'em_andamento'])
            ->with('pagamento')
            ->orderBy('data_coleta', 'asc')
            ->get();

        // Descartes concluídos (para notas fiscais)
        $agendamentosConcluidos = AgendamentoColeta::where('user_id', $user->id)
            ->where('status', 'concluido')
            ->with('pagamento')
            ->orderBy('data_coleta', 'desc')
            ->get();

        // Busca os resgates de produtos do usuário
        $redemptions = ProductRedemption::where('user_id', $user->id)
            ->with('product') // Carrega o relacionamento com o produto
            ->orderBy('created_at', 'desc')
            ->get();

        // Busca os tickets de suporte do usuário
        $tickets = SupportTicket::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // ✅ Caminho correto da view
        return view('tasks.historico', compact(
            'agendamentos',
            'agendamentosAndamento',
            'agendamentosConcluidos',
            'redemptions',
            'tickets'
        ));
    }
}