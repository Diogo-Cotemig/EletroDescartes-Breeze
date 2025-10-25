<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SupportController extends Controller
{
    /**
     * Listar todos os chamados com filtros e paginação
     */
    public function index(Request $request)
    {
        try {
            $query = SupportTicket::query();

            // Filtro por status
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            // Filtro por prioridade
            if ($request->has('priority') && $request->priority != '') {
                $query->where('priority', $request->priority);
            }

            // Filtro por categoria
            if ($request->has('category') && $request->category != '') {
                $query->where('category', $request->category);
            }

            // Busca por nome ou email
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Filtro por data
            if ($request->has('date_from') && $request->date_from != '') {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->has('date_to') && $request->date_to != '') {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Ordenação
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Paginação
            $perPage = $request->get('per_page', 15);
            $tickets = $query->paginate($perPage);

            // Estatísticas
            $stats = [
                'total' => SupportTicket::count(),
                'pendente' => SupportTicket::where('status', 'pendente')->count(),
                'em_andamento' => SupportTicket::where('status', 'em_andamento')->count(),
                'resolvido' => SupportTicket::where('status', 'resolvido')->count(),
            ];

            // Se for requisição AJAX, retorna JSON
            if ($request->wantsJson() || $request->ajax()) {
                $tickets->getCollection()->transform(function ($ticket) {
                    return [
                        'id' => $ticket->id,
                        'protocol' => str_pad($ticket->id, 6, '0', STR_PAD_LEFT),
                        'name' => $ticket->name,
                        'email' => $ticket->email,
                        'phone' => $ticket->phone,
                        'category' => $ticket->category,
                        'category_name' => $ticket->category_name,
                        'priority' => $ticket->priority,
                        'priority_name' => $ticket->priority_name,
                        'status' => $ticket->status,
                        'status_name' => $ticket->status_name,
                        'description' => $ticket->description,
                        'attachments' => $ticket->attachments,
                        'receive_notifications' => $ticket->receive_notifications,
                        'created_at' => $ticket->created_at->format('d/m/Y H:i'),
                        'updated_at' => $ticket->updated_at->format('d/m/Y H:i'),
                    ];
                });

                return response()->json([
                    'success' => true,
                    'data' => $tickets->items(),
                    'pagination' => [
                        'total' => $tickets->total(),
                        'per_page' => $tickets->perPage(),
                        'current_page' => $tickets->currentPage(),
                        'last_page' => $tickets->lastPage(),
                        'from' => $tickets->firstItem(),
                        'to' => $tickets->lastItem(),
                    ]
                ], 200);
            }

            // Retorna a view
            return view('chamados.index', compact('tickets', 'stats'));

        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao buscar chamados.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return back()->with('error', 'Erro ao buscar chamados: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar formulário de criação
     */
    public function create()
    {
        return view('chamados.create');
    }

    /**
     * Exibir um chamado específico
     */
    public function show($id)
    {
        try {
            $ticket = SupportTicket::findOrFail($id);

            // Se for requisição AJAX, retorna JSON
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $ticket->id,
                        'protocol' => str_pad($ticket->id, 6, '0', STR_PAD_LEFT),
                        'name' => $ticket->name,
                        'email' => $ticket->email,
                        'phone' => $ticket->phone,
                        'category' => $ticket->category,
                        'category_name' => $ticket->category_name,
                        'priority' => $ticket->priority,
                        'priority_name' => $ticket->priority_name,
                        'status' => $ticket->status,
                        'status_name' => $ticket->status_name,
                        'description' => $ticket->description,
                        'attachments' => $ticket->attachments,
                        'receive_notifications' => $ticket->receive_notifications,
                        'created_at' => $ticket->created_at->format('d/m/Y H:i:s'),
                        'updated_at' => $ticket->updated_at->format('d/m/Y H:i:s'),
                    ]
                ], 200);
            }

            // Retorna a view
            return view('chamados.show', compact('ticket'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chamado não encontrado.'
                ], 404);
            }

            return redirect()->route('chamados.index')->with('error', 'Chamado não encontrado.');

        } catch (\Exception $e) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao buscar chamado.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return back()->with('error', 'Erro ao buscar chamado.');
        }
    }

    /**
     * Buscar chamados por status
     */
    public function byStatus($status)
    {
        try {
            $validStatuses = ['pendente', 'em_andamento', 'resolvido', 'fechado'];

            if (!in_array($status, $validStatuses)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status inválido.',
                    'valid_statuses' => $validStatuses
                ], 400);
            }

            $tickets = SupportTicket::where('status', $status)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($ticket) {
                    return [
                        'id' => $ticket->id,
                        'protocol' => str_pad($ticket->id, 6, '0', STR_PAD_LEFT),
                        'name' => $ticket->name,
                        'email' => $ticket->email,
                        'category_name' => $ticket->category_name,
                        'priority_name' => $ticket->priority_name,
                        'status_name' => $ticket->status_name,
                        'created_at' => $ticket->created_at->format('d/m/Y H:i'),
                    ];
                });

            return response()->json([
                'success' => true,
                'status' => $status,
                'total' => $tickets->count(),
                'data' => $tickets
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar chamados por status.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Buscar chamados por prioridade
     */
    public function byPriority($priority)
    {
        try {
            $validPriorities = ['baixa', 'media', 'alta', 'urgente'];

            if (!in_array($priority, $validPriorities)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prioridade inválida.',
                    'valid_priorities' => $validPriorities
                ], 400);
            }

            $tickets = SupportTicket::where('priority', $priority)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($ticket) {
                    return [
                        'id' => $ticket->id,
                        'protocol' => str_pad($ticket->id, 6, '0', STR_PAD_LEFT),
                        'name' => $ticket->name,
                        'email' => $ticket->email,
                        'category_name' => $ticket->category_name,
                        'priority_name' => $ticket->priority_name,
                        'status_name' => $ticket->status_name,
                        'created_at' => $ticket->created_at->format('d/m/Y H:i'),
                    ];
                });

            return response()->json([
                'success' => true,
                'priority' => $priority,
                'total' => $tickets->count(),
                'data' => $tickets
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar chamados por prioridade.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Buscar chamados por categoria
     */
    public function byCategory($category)
    {
        try {
            $validCategories = ['coleta', 'agendamento', 'equipamento', 'certificado', 'pagamento', 'outro'];

            if (!in_array($category, $validCategories)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Categoria inválida.',
                    'valid_categories' => $validCategories
                ], 400);
            }

            $tickets = SupportTicket::where('category', $category)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($ticket) {
                    return [
                        'id' => $ticket->id,
                        'protocol' => str_pad($ticket->id, 6, '0', STR_PAD_LEFT),
                        'name' => $ticket->name,
                        'email' => $ticket->email,
                        'category_name' => $ticket->category_name,
                        'priority_name' => $ticket->priority_name,
                        'status_name' => $ticket->status_name,
                        'created_at' => $ticket->created_at->format('d/m/Y H:i'),
                    ];
                });

            return response()->json([
                'success' => true,
                'category' => $category,
                'total' => $tickets->count(),
                'data' => $tickets
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar chamados por categoria.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Armazenar novo chamado
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'category' => 'required|in:coleta,agendamento,equipamento,certificado,pagamento,outro',
            'priority' => 'required|in:baixa,media,alta,urgente',
            'description' => 'required|string|min:10',
            'attachment' => 'nullable|array',
            'attachment.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            'receive_notifications' => 'nullable|boolean',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser válido.',
            'category.required' => 'A categoria é obrigatória.',
            'category.in' => 'Categoria inválida.',
            'priority.required' => 'A prioridade é obrigatória.',
            'priority.in' => 'Prioridade inválida.',
            'description.required' => 'A descrição é obrigatória.',
            'description.min' => 'A descrição deve ter no mínimo 10 caracteres.',
            'attachment.*.mimes' => 'Formato de arquivo não permitido.',
            'attachment.*.max' => 'O arquivo deve ter no máximo 10MB.',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro na validação dos dados.',
                    'errors' => $validator->errors()
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        try {
            // Processar anexos (se houver)
            $attachments = [];
            if ($request->hasFile('attachment')) {
                foreach ($request->file('attachment') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('support_tickets', $filename, 'public');

                    $attachments[] = [
                        'original_name' => $file->getClientOriginalName(),
                        'stored_name' => $filename,
                        'path' => $path,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ];
                }
            }

            // Criar o ticket
            $ticket = SupportTicket::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'category' => $request->category,
                'priority' => $request->priority,
                'description' => $request->description,
                'attachments' => !empty($attachments) ? $attachments : null,
                'receive_notifications' => $request->has('receive_notifications') ?
                    filter_var($request->receive_notifications, FILTER_VALIDATE_BOOLEAN) : true,
                'status' => 'pendente',
            ]);

            // Se for requisição AJAX, retorna JSON
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Chamado criado com sucesso!',
                    'data' => [
                        'ticket_id' => $ticket->id,
                        'protocol' => str_pad($ticket->id, 6, '0', STR_PAD_LEFT),
                        'status' => $ticket->status,
                        'created_at' => $ticket->created_at->format('d/m/Y H:i'),
                    ]
                ], 201);
            }

            // Redireciona para a lista
            return redirect()->route('chamados.index')->with('success', 'Chamado criado com sucesso! Protocolo: #' . str_pad($ticket->id, 6, '0', STR_PAD_LEFT));

        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao criar o chamado. Por favor, tente novamente.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return back()->with('error', 'Erro ao criar o chamado.')->withInput();
        }
    }
}
