@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>🎁 Detalhes do Resgate #{{ $redemption->id }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produtos</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.products.redemptions') }}">Resgates</a></div>
            <div class="breadcrumb-item">Resgate #{{ $redemption->id }}</div>
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

        <div class="row">
            <!-- INFORMAÇÕES DO RESGATE -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Informações do Resgate</h4>
                        <div class="card-header-action">
                            @if($redemption->status === 'pending')
                                <span class="badge badge-warning badge-lg">
                                    <i class="fas fa-clock"></i> Pendente
                                </span>
                            @elseif($redemption->status === 'processing')
                                <span class="badge badge-info badge-lg">
                                    <i class="fas fa-spinner"></i> Em Processamento
                                </span>
                            @elseif($redemption->status === 'completed')
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-check"></i> Concluído
                                </span>
                            @else
                                <span class="badge badge-danger badge-lg">
                                    <i class="fas fa-times"></i> Cancelado
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!-- PRODUTO -->
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                @if($redemption->product_image)
                                    <img src="{{ asset($redemption->product_image) }}" 
                                         alt="{{ $redemption->product_name }}" 
                                         class="img-fluid rounded shadow-sm"
                                         style="max-width: 150px;">
                                @else
                                    <img src="{{ asset('uploads/no-image.png') }}" 
                                         alt="Sem imagem" 
                                         class="img-fluid rounded shadow-sm"
                                         style="max-width: 150px;">
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h5 class="mb-3">{{ $redemption->product_name }}</h5>
                                
                                <p class="text-muted">{{ $redemption->product_description }}</p>

                                @if($redemption->product)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> Produto ainda existe no sistema
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Produto foi excluído do sistema
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <!-- DETALHES -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted">Pontos Gastos</label>
                                    <h4 class="text-primary">
                                        <i class="fas fa-star"></i> 
                                        {{ number_format($redemption->points_spent, 0, ',', '.') }} pontos
                                    </h4>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted">Data do Resgate</label>
                                    <h5>{{ $redemption->created_at->format('d/m/Y \à\s H:i') }}</h5>
                                </div>
                            </div>

                            @if($redemption->processed_at)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted">Data de Conclusão</label>
                                    <h5>{{ $redemption->processed_at->format('d/m/Y \à\s H:i') }}</h5>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if($redemption->admin_notes)
                        <hr>
                        <div class="alert alert-info">
                            <strong>📝 Observações do Admin:</strong>
                            <p class="mb-0 mt-2">{{ $redemption->admin_notes }}</p>
                        </div>
                        @endif

                    </div>
                </div>

                <!-- AÇÕES -->
                <div class="card">
                    <div class="card-header">
                        <h4>Ações</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($redemption->status === 'pending')
                                <div class="col-md-6 mb-3">
                                    <button type="button" class="btn btn-primary btn-block btn-lg" 
                                            onclick="updateStatus('processing')">
                                        <i class="fas fa-play"></i> Iniciar Processamento
                                    </button>
                                </div>
                            @endif

                            @if($redemption->status !== 'completed')
                                <div class="col-md-6 mb-3">
                                    <button type="button" class="btn btn-success btn-block btn-lg" 
                                            onclick="updateStatus('completed')">
                                        <i class="fas fa-check"></i> Marcar como Concluído
                                    </button>
                                </div>
                            @endif

                            @if($redemption->status !== 'cancelled')
                                <div class="col-md-6 mb-3">
                                    <button type="button" class="btn btn-danger btn-block btn-lg" 
                                            onclick="cancelRedemption()">
                                        <i class="fas fa-ban"></i> Cancelar Resgate
                                    </button>
                                </div>
                            @endif

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('admin.products.redemptions') }}" class="btn btn-secondary btn-block btn-lg">
                                    <i class="fas fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INFORMAÇÕES DO USUÁRIO -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>👤 Informações do Usuário</h4>
                    </div>
                    <div class="card-body">
                        @if($redemption->user)
                            <div class="text-center mb-3">
                                <div class="avatar avatar-xl bg-primary text-white mx-auto mb-3" 
                                     style="width: 80px; height: 80px; line-height: 80px; font-size: 2rem;">
                                    {{ strtoupper(substr($redemption->user->name, 0, 1)) }}
                                </div>
                                <h5 class="mb-0">{{ $redemption->user->name }}</h5>
                                <p class="text-muted">{{ $redemption->user->email }}</p>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label class="text-muted">Pontos Atuais</label>
                                <h4 class="text-success">
                                    <i class="fas fa-star"></i> 
                                    {{ number_format($redemption->user->descarte_points, 2, ',', '.') }} pontos
                                </h4>
                            </div>

                            @if($redemption->user->created_at)
                            <div class="form-group">
                                <label class="text-muted">Cadastrado em</label>
                                <p>{{ $redemption->user->created_at->format('d/m/Y') }}</p>
                            </div>
                            @endif

                            <a href="mailto:{{ $redemption->user->email }}" class="btn btn-primary btn-block">
                                <i class="fas fa-envelope"></i> Enviar Email
                            </a>
                        @else
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                                Usuário não encontrado no sistema.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- TIMELINE -->
                <div class="card">
                    <div class="card-header">
                        <h4>📅 Linha do Tempo</h4>
                    </div>
                    <div class="card-body">
                        <div class="activities">
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="activity-detail">
                                    <p class="mb-0"><strong>Resgate Criado</strong></p>
                                    <p class="text-muted">{{ $redemption->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>

                            @if($redemption->status === 'processing' || $redemption->status === 'completed')
                            <div class="activity">
                                <div class="activity-icon bg-info text-white shadow-info">
                                    <i class="fas fa-spinner"></i>
                                </div>
                                <div class="activity-detail">
                                    <p class="mb-0"><strong>Em Processamento</strong></p>
                                    <p class="text-muted">{{ $redemption->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($redemption->status === 'completed')
                            <div class="activity">
                                <div class="activity-icon bg-success text-white shadow-success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-detail">
                                    <p class="mb-0"><strong>Concluído</strong></p>
                                    <p class="text-muted">
                                        {{ $redemption->processed_at ? $redemption->processed_at->format('d/m/Y H:i') : $redemption->updated_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            @endif

                            @if($redemption->status === 'cancelled')
                            <div class="activity">
                                <div class="activity-icon bg-danger text-white shadow-danger">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div class="activity-detail">
                                    <p class="mb-0"><strong>Cancelado</strong></p>
                                    <p class="text-muted">{{ $redemption->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
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
            <form id="statusForm" action="{{ route('admin.products.redemptions.updateStatus', $redemption->id) }}" method="POST">
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
                                  placeholder="Adicione observações sobre este resgate...">{{ $redemption->admin_notes }}</textarea>
                        <small class="form-text text-muted">
                            Estas observações serão visíveis para o usuário no histórico.
                        </small>
                    </div>

                    <div id="cancelWarning" class="alert alert-warning" style="display: none;">
                        <strong>⚠️ Atenção:</strong> Ao cancelar o resgate, os pontos serão devolvidos ao usuário e o estoque será restaurado (se o produto ainda existir).
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStatus(status) {
    const statusTexts = {
        'processing': 'Em Processamento',
        'completed': 'Concluído',
        'cancelled': 'Cancelado'
    };

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

function cancelRedemption() {
    updateStatus('cancelled');
}
</script>

@endsection