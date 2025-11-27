@extends('admin.layouts.master')

@section('content')
<section class="section">

    {{-- HEADER --}}
    <div class="section-header">
        <h1>🛠️ Chamados de Suporte</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active">Chamados</div>
        </div>
    </div>

    <div class="section-body">

        {{-- SUCESSO --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- CARDS DE STATUS --}}
        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Chamados Abertos</h4>
                        </div>
                        <div class="card-body">
                            {{ $tickets->where('status', 'aberto')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Em Andamento</h4>
                        </div>
                        <div class="card-body">
                            {{ $tickets->where('status', 'em_andamento')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Respondidos</h4>
                        </div>
                        <div class="card-body">
                            {{ $tickets->where('status', 'respondido')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total</h4>
                        </div>
                        <div class="card-body">
                            {{ $tickets->total() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- TABELA --}}
        <div class="card">
            <div class="card-header">
                <h4>Lista de Chamados</h4>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuário</th>
                                <th>Categoria</th>
                                <th>Prioridade</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th width="140">Ação</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($tickets as $ticket)
                                <tr>
                                    <td><strong>#{{ $ticket->id }}</strong></td>

                                    <td>
                                        {{ $ticket->user->name }}<br>
                                        <small class="text-muted">{{ $ticket->email }}</small>
                                    </td>

                                    <td>{{ $ticket->category }}</td>

                                    {{-- PRIORIDADE --}}
                                    <td>
                                        @php
                                            $prioColors = [
                                                'urgente' => 'danger',
                                                'alta' => 'warning',
                                                'media' => 'info',
                                                'baixa' => 'success'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $prioColors[$ticket->priority] }}">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        @php
                                            $statusColors = [
                                                'aberto' => 'warning',
                                                'em_andamento' => 'info',
                                                'respondido' => 'success',
                                                'fechado' => 'secondary'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $statusColors[$ticket->status] }}">
                                            {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                                        </span>
                                    </td>

                                    <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>

                                    <td>
                                        <a href="{{ route('admin.support.show', $ticket) }}" class="btn btn-primary btn-sm">
                                            Ver Detalhes
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        Nenhum chamado encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

            {{-- PAGINAÇÃO --}}
            <div class="card-footer text-center">
                {{ $tickets->links() }}
            </div>
        </div>

    </div>
</section>
@endsection
