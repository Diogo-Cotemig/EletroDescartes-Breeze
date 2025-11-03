@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>📦 Gerenciar Produtos</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Produtos</div>
        </div>
    </div>

    <div class="section-body">
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lista de Produtos</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Novo Produto
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Imagem</th>
                                        <th>Nome</th>
                                        <th>Preço</th>
                                        <th>Condição</th>
                                        <th>Estoque</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr>
                                            <td>
                                                @if($product->image)
                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <img src="{{ asset('uploads/no-image.png') }}" alt="Sem imagem" width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $product->name }}</strong><br>
                                                <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                            </td>
                                            <td><strong>{{ $product->formatted_price }}</strong></td>
                                            <td>
                                                @if($product->condition === 'novo')
                                                    <span class="badge badge-success">{{ $product->condition_label }}</span>
                                                @elseif($product->condition === 'seminovo')
                                                    <span class="badge badge-info">{{ $product->condition_label }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ $product->condition_label }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                @if($product->status === 'active')
                                                    <span class="badge badge-success">Ativo</span>
                                                @else
                                                    <span class="badge badge-danger">Inativo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Nenhum produto cadastrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
