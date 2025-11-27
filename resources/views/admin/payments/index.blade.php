@extends('admin.layouts.master')

@section('title', 'Lista de Pagamentos')

@section('content')
<section class="section">

    <div class="section-header">
        <h1>💰 Lista de Pagamentos</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </div>
            <div class="breadcrumb-item">Pagamentos</div>
        </div>
    </div>

    <div class="section-body">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- Cards de Estatísticas --}}
        <div class="row">

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header"><h4>Pendentes</h4></div>
                        <div class="card-body">
                            R$ {{ number_format($stats['total_pendente'], 2, ',', '.') }}
                            <br><small>{{ $stats['quantidade_pendente'] }} pagamentos</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header"><h4>Aprovados</h4></div>
                        <div class="card-body">
                            R$ {{ number_format($stats['total_aprovado'], 2, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header"><h4>Rejeitados</h4></div>
                        <div class="card-body">
                            R$ {{ number_format($stats['total_rejeitado'], 2, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header"><h4>Total Geral</h4></div>
                        <div class="card-body">
                            R$ {{ number_format($stats['total_pendente'] + $stats['total_aprovado'] + $stats['total_rejeitado'], 2, ',', '.') }}
                            <br><small>{{ $stats['quantidade_total'] }} registros</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Filtros --}}
        <div class="card">
            <div class="card-header">
                <h4>Filtros</h4>
            </div>
            <div class="card-body">

                <form method="GET" action="{{ route('admin.payments.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">Todos</option>
                                <option value="pendente"  {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="aprovado"  {{ request('status') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                <option value="rejeitado" {{ request('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Método</label>
                            <select name="metodo" class="form-control">
                                <option value="">Todos</option>
                                <option value="pix" {{ request('metodo') == 'pix' ? 'selected' : '' }}>Pix</option>
                                <option value="cartao" {{ request('metodo') == 'cartao' ? 'selected' : '' }}>Cartão</option>
                                <option value="boleto" {{ request('metodo') == 'boleto' ? 'selected' : '' }}>Boleto</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>Data Início</label>
                            <input type="date" name="data_inicio" class="form-control" value="{{ request('data_inicio') }}">
                        </div>

                        <div class="col-md-2">
                            <label>Data Fim</label>
                            <input type="date" name="data_fim" class="form-control" value="{{ request('data_fim') }}">
                        </div>

                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary btn-block">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-10">
                            <label>Buscar por ID ou Código PIX</label>
                            <input type="text" name="search" class="form-control" placeholder="Digite aqui..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-eraser"></i> Limpar
                            </a>
                        </div>
                    </div>

                </form>

            </div>
        </div>

        {{-- Tabela de Pagamentos --}}
        <div class="card">
            <div class="card-header">
                <h4>Pagamentos Registrados</h4>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID Agendamento</th>
                                <th>Valor</th>
                                <th>Método</th>
                                <th>Código PIX</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($pagamentos as $pagamento)
                            <tr>
                                <td><strong>#{{ $pagamento->id }}</strong></td>

                                <td>
                                    {{ $pagamento->agendamento_id ? '#'.$pagamento->agendamento_id : '-' }}
                                </td>

                                <td><strong class="text-success">R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</strong></td>

                                <td>
                                    @if($pagamento->metodo == 'pix')
                                        <span class="badge badge-info">PIX</span>
                                    @elseif($pagamento->metodo == 'cartao')
                                        <span class="badge badge-primary">Cartão</span>
                                    @else
                                        <span class="badge badge-secondary">Boleto</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $pagamento->codigo_pix ? Str::limit($pagamento->codigo_pix, 20) : '-' }}
                                </td>

                                <td>
                                    @if($pagamento->status == 'pendente')
                                        <span class="badge badge-warning">Pendente</span>
                                    @elseif($pagamento->status == 'aprovado')
                                        <span class="badge badge-success">Aprovado</span>
                                    @else
                                        <span class="badge badge-danger">Rejeitado</span>
                                    @endif
                                </td>

                                <td>{{ $pagamento->created_at->format('d/m/Y H:i') }}</td>

                                <td>
                                    <a href="{{ route('admin.payments.show', $pagamento) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Nenhum pagamento encontrado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="card-footer text-right">
                {{ $pagamentos->links() }}
            </div>
        </div>

    </div>
</section>

{{-- Hidden form --}}
<form id="statusForm" method="POST" style="display:none">
    @csrf
    @method('PATCH')
    <input type="hidden" id="statusInput" name="status">
</form>

@endsection
