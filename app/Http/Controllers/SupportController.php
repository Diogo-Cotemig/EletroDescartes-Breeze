<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    /**
     * Criar novo chamado (retorna JSON)
     */
    public function store(Request $request)
    {
        Log::info('Dados recebidos:', $request->all());

        try {
            $validated = $request->validate([
                'nameR' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'nullable|string|max:20',
                'category' => 'required|string',
                'priority' => 'required|in:baixa,media,alta,urgente',
                'description' => 'required|string|min:10',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            ]);

            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('support-tickets', 'public');
                Log::info('Arquivo enviado:', ['path' => $attachmentPath]);
            }

            $ticket = SupportTicket::create([
                'user_id' => Auth::id(),
                'name' => $validated['nameR'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'category' => $validated['category'],
                'priority' => $validated['priority'],
                'description' => $validated['description'],
                'attachment' => $attachmentPath,
                'status' => 'aberto',
            ]);

            Log::info('Ticket criado com sucesso!', ['ticket_id' => $ticket->id]);

            return response()->json([
                'success' => true,
                'message' => 'Chamado criado com sucesso!',
                'ticket' => $ticket,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erro ao criar ticket:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Erro ao criar chamado: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Listar chamados do usuário autenticado
     */
    public function myTickets()
    {
        $tickets = Auth::user()->supportTickets()->latest()->get();

        return response()->json([
            'success' => true,
            'tickets' => $tickets,
        ]);
    }

    /**
     * Histórico (mesmo que myTickets, mas separado caso queira endpoint diferente)
     */
    public function historico()
    {
        $tickets = Auth::user()->supportTickets()->latest()->get();

        return view('tasks.historico', compact('tickets'));
    }

    /**
     * Admin: listar todos os chamados
     */
    public function adminIndex()
    {
        $tickets = SupportTicket::with('user')->latest()->paginate(20);

        // Calcular estatísticas
        $stats = [
            'abertos' => SupportTicket::where('status', 'aberto')->count(),
            'em_andamento' => SupportTicket::where('status', 'em_andamento')->count(),
            'respondidos' => SupportTicket::where('status', 'respondido')->count(),
            'fechados' => SupportTicket::where('status', 'fechado')->count(),
        ];

        return view('admin.support.index', compact('tickets', 'stats'));
    }

    /**
     * Admin: ver detalhes de um chamado
     */
    public function adminShow(SupportTicket $ticket)
    {
        $ticket->load('user');

        return view('admin.support.show', compact('ticket'));
    }

    /**
     * Admin: responder chamado
     */
    public function adminRespond(Request $request, SupportTicket $ticket)
    {
        try {
            $validated = $request->validate([
                'response' => 'required|string|min:10',
                'status' => 'required|in:em_andamento,respondido,fechado',
            ]);

            $ticket->update([
                'admin_response' => $validated['response'],
                'status' => $validated['status'],
                'responded_by' => Auth::id(),
                'responded_at' => now(),
            ]);

            return redirect()->route('admin.support.index')->with('success', 'Resposta enviada com sucesso!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            Log::error('Erro ao responder chamado:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return redirect()->back()->with('error', 'Erro ao responder chamado: ' . $e->getMessage());
        }
    }
}
