<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pagamento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Pagamento::query()->with('user', 'agendamento');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('metodo')) {
            $query->where('metodo', $request->metodo);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('codigo_pix', 'like', '%' . $request->search . '%')
                  ->orWhere('id', $request->search);
            });
        }

        $pagamentos = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total_pendente' => Pagamento::where('status', 'pendente')->sum('valor'),
            'total_aprovado' => Pagamento::where('status', 'aprovado')->sum('valor'),
            'total_rejeitado' => Pagamento::where('status', 'rejeitado')->sum('valor'),
            'quantidade_pendente' => Pagamento::where('status', 'pendente')->count(),
            'quantidade_total' => Pagamento::count(),
        ];

        return view('admin.payments.index', compact('pagamentos', 'stats'));
    }

    public function show(Pagamento $payment)
    {
        $payment->load('user', 'agendamento');
        return view('admin.payments.show', compact('payment'));
    }

    public function updateStatus(Request $request, Pagamento $payment)
    {
        $request->validate([
            'status' => 'required|in:pendente,aprovado,rejeitado',
            'descarte_points' => 'nullable|numeric|min:0|max:999999.99',
        ]);

        DB::beginTransaction();
        
        try {
            $oldStatus = $payment->status;
            $newStatus = $request->status;

            $payment->status = $newStatus;

          
            if ($newStatus === 'aprovado' && $oldStatus !== 'aprovado') {
                
                $pointsToAward = floatval($request->input('descarte_points', 0));

       
                $user = null;

                // 1️⃣ Tenta pelo user_id do pagamento
                if ($payment->user_id) {
                    $user = $payment->user;
                }

                // 2️⃣ Tenta pelo user_id do agendamento
                if (!$user && $payment->agendamento && $payment->agendamento->user_id) {
                    $user = $payment->agendamento->usuario;
                }

                // 3️⃣ 🔥 BUSCA PELO EMAIL DO AGENDAMENTO (NOVO!)
                if (!$user && $payment->agendamento && $payment->agendamento->email) {
                    $user = User::where('email', $payment->agendamento->email)->first();
                    
                    // Se encontrou, vincula nos dois lugares
                    if ($user) {
                        $payment->agendamento->user_id = $user->id;
                        $payment->agendamento->save();
                    }
                }

                // Se AINDA não encontrou o usuário, retorna erro
                if (!$user) {
                    DB::rollBack();
                    $errorMessage = 'Usuário não encontrado! ';
                    if ($payment->agendamento) {
                        $errorMessage .= "Email do agendamento: {$payment->agendamento->email}. ";
                        $errorMessage .= "Verifique se existe um usuário cadastrado com este email.";
                    }
                    return redirect()->back()->with('error', $errorMessage);
                }

                // Vincula o usuário ao pagamento
                $payment->user_id = $user->id;

                // ADICIONA OS PONTOS AO USUÁRIO
                $user->descarte_points = ($user->descarte_points ?? 0) + $pointsToAward;
                $user->save();

                // Salva quantos pontos foram concedidos
                $payment->points_awarded = $pointsToAward;

                $message = $pointsToAward > 0 
                    ? "Pagamento aprovado com sucesso! {$pointsToAward} Descarte Points concedidos ao usuário {$user->name}."
                    : "Pagamento aprovado com sucesso!";
            } else {
                $message = 'Status do pagamento atualizado com sucesso!';
            }

            $payment->save();

            DB::commit();

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Erro ao atualizar pagamento: ' . $e->getMessage());
        }
    }
}