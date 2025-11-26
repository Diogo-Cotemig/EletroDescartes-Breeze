@extends('admin.layouts.master')
@section('title', 'Detalhes do Pagamento')

@section('content')

<section class="section">

    <div class="section-header">
        <h1><i class="fas fa-file-invoice-dollar"></i> Detalhes do Pagamento #{{ $payment->id }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Pagamentos</a></div>
            <div class="breadcrumb-item active">Detalhes</div>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-has-icon">
            <div class="alert-icon"><i class="far fa-check-circle"></i></div>
            <div class="alert-body">
                <div class="alert-title">Sucesso</div>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-has-icon">
            <div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="alert-body">
                <div class="alert-title">Erro</div>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="row">

        <!-- Informações principais -->
        <div class="col-lg-8">

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4><i class="fas fa-info-circle"></i> Informações do Pagamento</h4>

                    @if($payment->status == 'pendente')
                        <span class="badge badge-warning"><i class="fas fa-clock"></i> Pendente</span>
                    @elseif($payment->status == 'aprovado')
                        <span class="badge badge-success"><i class="fas fa-check"></i> Aprovado</span>
                    @else
                        <span class="badge badge-danger"><i class="fas fa-times"></i> Rejeitado</span>
                    @endif
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="text-muted small">ID DO PAGAMENTO</div>
                            <h4>#{{ $payment->id }}</h4>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="text-muted small">VALOR</div>
                            <h4 class="text-success">
                                R$ {{ number_format($payment->valor, 2, ',', '.') }}
                            </h4>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="text-muted small">MÉTODO</div>
                            @if($payment->metodo == 'pix')
                                <span class="badge badge-info"><i class="fas fa-qrcode"></i> PIX</span>
                            @elseif($payment->metodo == 'cartao')
                                <span class="badge badge-primary"><i class="fas fa-credit-card"></i> Cartão</span>
                            @else
                                <span class="badge badge-secondary"><i class="fas fa-barcode"></i> Boleto</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    {{-- Usuário --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-muted small">USUÁRIO</div>

                            @php
                                $displayUser = $payment->user
                                    ?? $payment->agendamento?->usuario
                                    ?? ($payment->agendamento ? \App\Models\User::where('email', $payment->agendamento->email)->first() : null);
                            @endphp

                            @if($displayUser)
                                <p class="h6 mt-1">
                                    <i class="fas fa-user"></i> {{ $displayUser->name }}<br>
                                    <small class="text-muted">{{ $displayUser->email }}</small>
                                </p>
                            @else
                                <p class="text-muted">Não vinculado</p>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">AGENDAMENTO</div>
                            <p class="h6 mt-1">
                                @if($payment->agendamento_id)
                                    #{{ $payment->agendamento_id }}
                                @else
                                    <span class="text-muted">Não vinculado</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr>

                    {{-- Status e pontos --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">STATUS</div>
                            <p class="h6 mt-1">
                                @if($payment->status == 'pendente')
                                    <span class="text-warning"><i class="fas fa-clock"></i> Aguardando aprovação</span>
                                @elseif($payment->status == 'aprovado')
                                    <span class="text-success"><i class="fas fa-check"></i> Confirmado</span>
                                @else
                                    <span class="text-danger"><i class="fas fa-times"></i> Rejeitado</span>
                                @endif
                            </p>
                        </div>

                        @if($payment->points_awarded > 0)
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small">DESCARTE POINTS</div>
                            <h6 class="mt-1 text-primary">
                                <i class="fas fa-star"></i> {{ number_format($payment->points_awarded, 2, ',', '.') }}
                            </h6>
                        </div>
                        @endif
                    </div>

                    {{-- Código PIX --}}
                    @if($payment->codigo_pix)
                        <hr>
                        <div class="mb-3">
                            <div class="text-muted small mb-2">CÓDIGO PIX</div>
                            <input type="text" class="form-control" readonly value="{{ $payment->codigo_pix }}">
                        </div>
                    @endif

                    <hr>

                    {{-- Datas --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-muted small">CRIADO EM</div>
                            <p><i class="far fa-calendar-plus"></i> {{ $payment->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">ATUALIZADO EM</div>
                            <p><i class="far fa-calendar-check"></i> {{ $payment->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    {{-- Aprovar ou rejeitar --}}
                    @if($payment->status == 'pendente')

                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle"></i> Este pagamento está aguardando análise.
                        </div>

                        {{-- Aprovar --}}
                        <div class="card card-success">
                            <div class="card-header"><h4><i class="fas fa-check-circle"></i> Aprovar Pagamento</h4></div>
                            <div class="card-body">

                                <form method="POST" action="{{ route('admin.payments.updateStatus', $payment) }}">
                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden" name="status" value="aprovado">

                                    <div class="form-group">
                                        <label><i class="fas fa-star text-warning"></i> Descarte Points</label>
                                        <input type="number" class="form-control" name="descarte_points" step="0.01" value="0">
                                    </div>

                                    <button class="btn btn-success btn-lg btn-block">
                                        <i class="fas fa-check"></i> Aprovar Pagamento
                                    </button>
                                </form>

                            </div>
                        </div>

                        {{-- Rejeitar --}}
                        <div class="card card-danger mt-3">
                            <div class="card-header"><h4><i class="fas fa-times-circle"></i> Rejeitar</h4></div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.payments.updateStatus', $payment) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejeitado">

                                    <button class="btn btn-danger btn-lg btn-block"
                                        onclick="return confirm('Tem certeza que deseja rejeitar este pagamento?')">
                                        <i class="fas fa-times"></i> Rejeitar Pagamento
                                    </button>
                                </form>
                            </div>
                        </div>

                    @endif

                </div>
            </div>

        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">

            {{-- Resumo --}}
            <div class="card">
                <div class="card-header"><h4>Resumo</h4></div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><strong>ID:</strong> #{{ $payment->id }}</li>
                        <li><strong>Valor:</strong> R$ {{ number_format($payment->valor, 2, ',', '.') }}</li>
                        <li><strong>Método:</strong> {{ ucfirst($payment->metodo) }}</li>
                        <li><strong>Status:</strong>
                            @if($payment->status == 'pendente')
                                <span class="badge badge-warning">Pendente</span>
                            @elseif($payment->status == 'aprovado')
                                <span class="badge badge-success">Aprovado</span>
                            @else
                                <span class="badge badge-danger">Rejeitado</span>
                            @endif
                        </li>

                        @if($payment->points_awarded > 0)
                            <li><strong>Pontos concedidos:</strong>
                                <span class="badge badge-primary">{{ number_format($payment->points_awarded, 2, ',', '.') }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            {{-- Usuário --}}
            @if($payment->user)
            <div class="card">
                <div class="card-header"><h4>Usuário</h4></div>
                <div class="card-body text-center">

                    @if($payment->user->image)
                        <img src="{{ asset($payment->user->image) }}" class="rounded-circle mb-3" width="80">
                    @else
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ strtoupper(substr($payment->user->name, 0, 1)) }}
                        </div>
                    @endif

                    <p class="mb-1"><strong>{{ $payment->user->name }}</strong></p>
                    <p class="text-muted">{{ $payment->user->email }}</p>

                    <span class="badge badge-primary">
                        <i class="fas fa-star"></i> {{ number_format($payment->user->descarte_points ?? 0, 2, ',', '.') }}
                    </span>

                </div>
            </div>
            @endif

            {{-- Histórico --}}
            <div class="card">
                <div class="card-header"><h4>Histórico</h4></div>
                <div class="card-body">

                    <ul class="list-unstyled">

                        <li class="mb-3">
                            <i class="fas fa-plus-circle text-primary"></i>
                            Criado em <br>
                            <small class="text-muted">{{ $payment->created_at->format('d/m/Y H:i') }}</small>
                        </li>

                        @if($payment->created_at != $payment->updated_at)
                        <li class="mb-3">
                            <i class="fas fa-edit text-info"></i>
                            Atualizado em <br>
                            <small class="text-muted">{{ $payment->updated_at->format('d/m/Y H:i') }}</small>
                        </li>
                        @endif

                        @if($payment->status == 'aprovado')
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success"></i>
                                Aprovado <br>
                                <small class="text-muted">{{ $payment->updated_at->format('d/m/Y H:i') }}</small>
                            </li>
                        @elseif($payment->status == 'rejeitado')
                            <li class="mb-3">
                                <i class="fas fa-times-circle text-danger"></i>
                                Rejeitado <br>
                                <small class="text-muted">{{ $payment->updated_at->format('d/m/Y H:i') }}</small>
                            </li>
                        @endif

                    </ul>

                </div>
            </div>

            {{-- Ações --}}
            <div class="card">
                <div class="card-header"><h4>Ações</h4></div>
                <div class="card-body">
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Voltar à Lista
                    </a>
                </div>
            </div>

        </div>

    </div>

</section>

@endsection
