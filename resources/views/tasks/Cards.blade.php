<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Disponíveis</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">🛒 Resgate Seus pontos !</h1>
            <p class="lead text-muted">Confira nossos produtos em estoque, use seus pontos para resgatar-los !</p>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm product-card">
                        <!-- Badge -->
                        @if($product->badge)
                            <div class="badge-corner">
                                <span class="badge badge-danger">{{ $product->badge }}</span>
                            </div>
                        @endif

                        <!-- Imagem do Produto -->
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}"
                                     class="card-img-top"
                                     alt="{{ $product->name }}"
                                     style="height: 250px; object-fit: cover;">
                            @else
                                <img src="{{ asset('uploads/no-image.png') }}"
                                     class="card-img-top"
                                     alt="Sem imagem"
                                     style="height: 250px; object-fit: cover;">
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <!-- Nome do Produto -->
                            <h5 class="card-title font-weight-bold">{{ $product->name }}</h5>

                            <!-- Descrição -->
                            <p class="card-text text-muted small">
                                {{ Str::limit($product->description, 80) }}
                            </p>

                            <!-- Condição -->
                            <div class="mb-2">
                                @if($product->condition === 'novo')
                                    <span class="badge badge-success">Novo</span>
                                @elseif($product->condition === 'seminovo')
                                    <span class="badge badge-info">Seminovo</span>
                                @else
                                    <span class="badge badge-warning">Usado</span>
                                @endif

                                @if($product->category)
                                    <span class="badge badge-secondary">{{ $product->category }}</span>
                                @endif
                            </div>

                            <!-- Preço -->
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-primary mb-0">
                                        <strong>R$ {{ number_format($product->price, 2, ',', '.') }}</strong>
                                    </h4>
                                    <small class="text-muted">Estoque: {{ $product->stock }}</small>
                                </div>

                                <!-- Botões -->
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary btn-block">
                                        <i class="fas fa-cart-plus"></i> Comprar
                                    </button>
                                    <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#productModal{{ $product->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de Detalhes -->
                <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $product->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('uploads/no-image.png') }}" class="img-fluid rounded" alt="Sem imagem">
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="text-primary">Pontos Nescessarios: {{ number_format($product->price) }}</h4>
                                        <p><strong>Condição:</strong> {{ ucfirst($product->condition) }}</p>
                                        @if($product->category)
                                            <p><strong>Categoria:</strong> {{ $product->category }}</p>
                                        @endif
                                        <p><strong>Estoque disponível:</strong> {{ $product->stock }} unidades</p>
                                        <hr>
                                        <h6>Descrição:</h6>
                                        <p>{{ $product->description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-cart-plus"></i> Adicionar ao Carrinho
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginação -->
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4>😔 Nenhum produto disponível no momento</h4>
                    <p>Volte em breve para conferir nossos produtos!</p>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
}

.badge-corner {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
}

.product-image {
    position: relative;
    overflow: hidden;
}

.product-image img {
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.btn-block {
    width: 100%;
}

.gap-2 {
    gap: 0.5rem;
}
</style>
