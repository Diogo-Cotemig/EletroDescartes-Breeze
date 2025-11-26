<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\ProductRedemption;
use Illuminate\Support\Facades\Auth;

class HistoricoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Busca os tickets de suporte do usuário
        $tickets = SupportTicket::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Busca os resgates de produtos do usuário
        $redemptions = ProductRedemption::where('user_id', $user->id)
            ->with('product') // Carrega o relacionamento com o produto
            ->orderBy('created_at', 'desc')
            ->get();

        // ✅ Caminho correto da view
        return view('tasks.historico', compact('tickets', 'redemptions'));
    }
}