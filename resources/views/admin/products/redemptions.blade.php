@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>🎁 Resgates de Produtos</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produtos</a></div>
            <div class="breadcrumb-item">Resgates</div>
        </div>
    </div>

    <div class="section-body">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- ESTATÍSTICAS -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pendentes</h4>
                        </div>
                        <div class="card-body">
                            {{ $stats['total_pending'] }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Em Processamento</h4>
                        </div>
                        <div class="card-body">
                            {{ $stats['total_processing'] }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Concluídos</h4>
                        </div>
                        <div class="card-body">
                            {{ $stats['total_completed'] }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Cancelados</h4>
                        </div>
                        <div class="card-body">
                            {{ $stats['total_cancelled'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FILTROS -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Filtros</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.products.redemptions') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Todos</option>
                                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendente</option>
                                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Em Processamento</option>
                                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Concluído</option>
                                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Buscar</label>
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="ID, produto, usuário..." value="{{ request('search') }}">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Data Início</label>
                                        <input type="date" name="data_inicio" class="form-control" value="{{ request('data_inicio') }}">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Data Fim</label>
                                        <input type="date" name="data_fim" class="form-control" value="{{ request('data_fim') }}">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-search"></i> Filtrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABELA DE RESGATES -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lista de Resgates ({{ $redemptions->total() }})</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar para Produtos
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuário</th>
                                        <th>Produto</th>
                                        <th>Pontos</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                        <th style="width: 200px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($redemptions as $redemption)
                                        <tr>
                                            <td><strong>#{{ $redemption->id }}</strong></td>
                                            <td>
                                                @if($redemption->user)
                                                    <strong>{{ $redemption->user->name }}</strong><br>
                                                    <small class="text-muted">{{ $redemption->user->email }}</small>
                                                @else
                                                    <span class="text-danger">Usuário não encontrado</span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $redemption->product_name }}</strong><br>
                                                @if($redemption->product)
                                                    <small class="text-success">
                                                        <i class="fas fa-check"></i> Produto existe
                                                    </small>
                                                @else
                                                    <small class="text-warning">
                                                        <i class="fas fa-exclamation-triangle"></i> Produto excluído
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <strong class="text-primary">{{ number_format($redemption->points_spent, 0, ',', '.') }}</strong> pts
                                            </td>
                                            <td>
                                                {{ $redemption->created_at->format('d/m/Y') }}<br>
                                                <small class="text-muted">{{ $redemption->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                @if($redemption->status === 'pending')
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-clock"></i> Pendente
                                                    </span>
                                                @elseif($redemption->status === 'processing')
                                                    <span class="badge badge-info">
                                                        <i class="fas fa-spinner"></i> Processando
                                                    </span>
                                                @elseif($redemption->status === 'completed')
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check"></i> Concluído
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-times"></i> Cancelado
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.products.redemptions.show', $redemption->id) }}" 
                                                       class="btn btn-sm btn-info" title="Ver Detalhes">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    @if($redemption->status !== 'completed')
                                                        <button type="button" class="btn btn-sm btn-success" 
                                                                onclick="updateStatus({{ $redemption->id }}, 'completed')"
                                                                title="Marcar como Concluído">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif

                                                    @if($redemption->status === 'pending')
                                                        <button type="button" class="btn btn-sm btn-primary" 
                                                                onclick="updateStatus({{ $redemption->id }}, 'processing')"
                                                                title="Iniciar Processamento">
                                                            <i class="fas fa-play"></i>
                                                        </button>
                                                    @endif

                                                    @if($redemption->status !== 'cancelled')
                                                        <button type="button" class="btn btn-sm btn-danger" 
                                                                onclick="cancelRedemption({{ $redemption->id }})"
                                                                title="Cancelar Resgate">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                                <p class="text-muted">Nenhum resgate encontrado.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $redemptions->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Modal para atualizar status -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="statusForm" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="modal-header">
                    <h5 class="modal-title">Atualizar Status do Resgate</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="status" id="modalStatus">
                    
                    <div class="alert alert-info">
                        <strong>Novo Status:</strong> <span id="modalStatusText"></span>
                    </div>

                    <div class="form-group">
                        <label>Observações (opcional)</label>
                        <textarea name="admin_notes" class="form-control" rows="4" 
                                  placeholder="Adicione observações sobre este resgate..."></textarea>
                        <small class="form-text text-muted">
                            Estas observações serão visíveis para o usuário no histórico.
                        </small>
                    </div>

                    <div id="cancelWarning" class="alert alert-warning" style="display: none;">
                        <strong>⚠️ Atenção:</strong> Ao cancelar o resgate, os pontos serão devolvidos ao usuário e o estoque será restaurado (se o produto ainda existir).
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStatus(redemptionId, status) {
    const statusTexts = {
        'processing': 'Em Processamento',
        'completed': 'Concluído',
        'cancelled': 'Cancelado'
    };

    document.getElementById('statusForm').action = `/admin/products-redemptions/${redemptionId}/status`;
    document.getElementById('modalStatus').value = status;
    document.getElementById('modalStatusText').textContent = statusTexts[status];
    
    // Mostra aviso de cancelamento
    if (status === 'cancelled') {
        document.getElementById('cancelWarning').style.display = 'block';
    } else {
        document.getElementById('cancelWarning').style.display = 'none';
    }

    $('#statusModal').modal('show');
}

function cancelRedemption(redemptionId) {
    updateStatus(redemptionId, 'cancelled');
}
</script>

@endsection