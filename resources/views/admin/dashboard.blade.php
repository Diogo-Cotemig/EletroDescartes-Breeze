@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>📊 Painel de Controle</h1>
        </div>

        <div class="row">
            <!-- Total de Administradores -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Administradores</h4>
                        </div>
                        <div class="card-body">
                            {{ $stats['admins'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total de Produtos -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Produtos</h4>
                        </div>
                        <div class="card-body">
                            {{ $stats['products'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total de Vendedores -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Vendedores</h4>
                        </div>
                        <div class="card-body">
                            {{ $stats['vendors'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total de Clientes -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Clientes</h4>
                        </div>
                        <div class="card-body">
                            {{ $stats['customers'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produtos Recentes -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>📦 Produtos Recentes</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Ver Todos</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Imagem</th>
                                        <th>Nome</th>
                                        <th>Preço</th>
                                        <th>Estoque</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentProducts as $product)
                                        <tr>
                                            <td>
                                                @if($product->image)
                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                                                @else
                                                    <img src="{{ asset('uploads/no-image.png') }}" alt="Sem imagem" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td><strong>{{ $product->formatted_price }}</strong></td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                @if($product->status === 'active')
                                                    <span class="badge badge-success">Ativo</span>
                                                @else
                                                    <span class="badge badge-danger">Inativo</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Nenhum produto cadastrado</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>⚡ Ações Rápidas - Fast Travel</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-block btn-lg mb-3">
                                    <i class="fas fa-plus"></i> Novo Produto
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-block btn-lg mb-3">
                                    <i class="fas fa-box"></i> Ver Produtos
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.support.index') }}" class="btn btn-warning btn-block btn-lg mb-3">
                                    <i class="fas fa-ticket-alt"></i> Suporte
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.profile') }}" class="btn btn-info btn-block btn-lg mb-3">
                                    <i class="fas fa-user"></i> Meu Perfil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
