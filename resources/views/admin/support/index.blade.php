<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Chamados</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 { color: #333; margin-bottom: 30px; }
        .alert {
            padding: 15px;
            background: #d4edda;
            color: #155724;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
        }
        .stat-card h3 { font-size: 40px; margin-bottom: 10px; }
        .stat-card p { font-size: 16px; opacity: 0.9; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #667eea;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-aberto { background: #fff3cd; color: #856404; }
        .badge-em_andamento { background: #cce5ff; color: #004085; }
        .badge-respondido { background: #d4edda; color: #155724; }
        .badge-fechado { background: #d6d8db; color: #383d41; }
        .badge-urgente { background: #dc3545; color: white; }
        .badge-alta { background: #fd7e14; color: white; }
        .badge-media { background: #ffc107; color: #333; }
        .badge-baixa { background: #28a745; color: white; }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5568d3;
        }
        .pagination {
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛠️ Painel de Suporte - Admin</h1>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="stats">
            <div class="stat-card">
                <h3>{{ $tickets->where('status', 'aberto')->count() }}</h3>
                <p>🔴 Abertos</p>
            </div>
            <div class="stat-card">
                <h3>{{ $tickets->where('status', 'em_andamento')->count() }}</h3>
                <p>🟡 Em Andamento</p>
            </div>
            <div class="stat-card">
                <h3>{{ $tickets->where('status', 'respondido')->count() }}</h3>
                <p>🟢 Respondidos</p>
            </div>
            <div class="stat-card">
                <h3>{{ $tickets->total() }}</h3>
                <p>📊 Total</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Categoria</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <td><strong>#{{ $ticket->id }}</strong></td>
                        <td>
                            {{ $ticket->user->name }}<br>
                            <small style="color: #666;">{{ $ticket->email }}</small>
                        </td>
                        <td>{{ $ticket->category }}</td>
                        <td>
                            <span class="badge badge-{{ $ticket->priority }}">
                                @if($ticket->priority === 'urgente') 🚨 Urgente
                                @elseif($ticket->priority === 'alta') 🔴 Alta
                                @elseif($ticket->priority === 'media') 🟡 Média
                                @else 🟢 Baixa
                                @endif
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $ticket->status }}">
                                @if($ticket->status === 'aberto') Aberto
                                @elseif($ticket->status === 'em_andamento') Em Andamento
                                @elseif($ticket->status === 'respondido') Respondido
                                @else Fechado
                                @endif
                            </span>
                        </td>
                        <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.support.show', $ticket) }}" class="btn btn-primary">
                                Ver Detalhes
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                            Nenhum chamado encontrado
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $tickets->links() }}
        </div>
    </div>
</body>
</html>
