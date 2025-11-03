<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Chamado #{{ $ticket->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        h1 { color: #333; }
        .btn-back {
            padding: 12px 24px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-back:hover { background: #5a6268; }
        .info-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .info-item {
            margin-bottom: 15px;
        }
        .info-label {
            font-weight: 600;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }
        .info-value {
            color: #333;
            font-size: 18px;
        }
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-aberto { background: #fff3cd; color: #856404; }
        .badge-em_andamento { background: #cce5ff; color: #004085; }
        .badge-respondido { background: #d4edda; color: #155724; }
        .badge-fechado { background: #d6d8db; color: #383d41; }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .description-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            line-height: 1.6;
            white-space: pre-wrap;
        }
        .response-box {
            background: #e7f5e7;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
            margin-bottom: 20px;
            white-space: pre-wrap;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        textarea, select {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        textarea:focus, select:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn-primary {
            padding: 15px 30px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎫 Chamado #{{ $ticket->id }}</h1>
            <a href="{{ route('admin.support.index') }}" class="btn-back">← Voltar</a>
        </div>

        <div class="info-box">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">👤 Usuário</span>
                    <span class="info-value">{{ $ticket->user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">📧 E-mail</span>
                    <span class="info-value">{{ $ticket->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">📱 Telefone</span>
                    <span class="info-value">{{ $ticket->phone ?? 'Não informado' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">📋 Categoria</span>
                    <span class="info-value">{{ $ticket->category }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">⚡ Prioridade</span>
                    <span class="info-value">
                        @if($ticket->priority === 'urgente') 🚨 Urgente
                        @elseif($ticket->priority === 'alta') 🔴 Alta
                        @elseif($ticket->priority === 'media') 🟡 Média
                        @else 🟢 Baixa
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">📊 Status</span>
                    <span class="badge badge-{{ $ticket->status }}">
                        @if($ticket->status === 'aberto') Aberto
                        @elseif($ticket->status === 'em_andamento') Em Andamento
                        @elseif($ticket->status === 'respondido') Respondido
                        @else Fechado
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">📅 Aberto em</span>
                    <span class="info-value">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($ticket->responded_at)
                    <div class="info-item">
                        <span class="info-label">✅ Respondido em</span>
                        <span class="info-value">{{ $ticket->responded_at->format('d/m/Y H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">📝 Descrição do Problema</h2>
            <div class="description-box">{{ $ticket->description }}</div>

      @if($ticket->attachment)
    <div style="margin-top: 15px;">
        <a href="{{ Storage::url($ticket->attachment) }}" target="_blank"
           style="color: #667eea; text-decoration: none; font-weight: 600;">
            📎 Ver anexo
        </a>
    </div>
@endif

        @if($ticket->admin_response)
            <div class="section">
                <h2 class="section-title">✅ Resposta Enviada</h2>
                <div class="response-box">{{ $ticket->admin_response }}</div>
                <small style="color: #666;">
                    Respondido em {{ $ticket->responded_at->format('d/m/Y H:i') }}
                    @if($ticket->respondedBy)
                        por {{ $ticket->respondedBy->name }}
                    @endif
                </small>
            </div>
        @endif

        <div class="section">
            <h2 class="section-title">💬 {{ $ticket->admin_response ? 'Atualizar Resposta' : 'Responder Chamado' }}</h2>

            <form action="{{ route('admin.support.respond', $ticket) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Resposta *</label>
                    <textarea name="response" rows="6" required placeholder="Digite sua resposta...">{{ old('response', $ticket->admin_response) }}</textarea>
                    @error('response')
                        <small style="color: #dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Atualizar Status *</label>
                    <select name="status" required>
                        <option value="em_andamento" {{ old('status', $ticket->status) === 'em_andamento' ? 'selected' : '' }}>
                            Em Andamento
                        </option>
                        <option value="respondido" {{ old('status', $ticket->status) === 'respondido' ? 'selected' : '' }}>
                            Respondido
                        </option>
                        <option value="fechado" {{ old('status', $ticket->status) === 'fechado' ? 'selected' : '' }}>
                            Fechado
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn-primary">💾 Salvar Resposta</button>
            </form>
        </div>
    </div>
</body>
</html>
