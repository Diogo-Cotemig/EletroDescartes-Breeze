<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Resgatar Produtos</title>

    <!-- Bootstrap + FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="icon" type="image/png" href="{{ asset('img/Eletro-DescarteLOGO.png') }}">
    @vite(['resources/css/historico.css'])
</head>

<body>

<!-- ===== FUNDO DARK E ILUMINAÇÃO VERDE ===== -->
<div class="neon-bg"></div>

<div class="container py-5 text-white">

    <!-- ===== PONTOS DO USUÁRIO ===== -->
    <div class="user-points-box">
        <i class="fas fa-star"></i>
        <strong id="userPoints">{{ number_format(Auth::user()->descarte_points ?? 0, 2, ',', '.') }}</strong> pontos
    </div>

    <!-- TÍTULO -->
    <div class="row mb-5 text-center">
        <div class="col-12">
            <h1 class="display-4 text-neon">Resgate Seus Pontos!</h1>
            <p class="lead text-light">Escolha um produto e troque pelos seus pontos acumulados.</p>
        </div>
    </div>

    <!-- ===== LISTA DE PRODUTOS ===== -->
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card shadow-lg">

                        @if($product->badge)
                        <div class="badge-tag">
                            {{ $product->badge }}
                        </div>
                        @endif

                        <div class="product-img">
                            <img src="{{ $product->image ? asset($product->image) : asset('uploads/no-image.png') }}"
                                 alt="{{ $product->name }}">
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-white">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 70) }}</p>

                            <div class="mb-2">
                                @if($product->condition === 'novo')
                                    <span class="badge badge-success">Novo</span>
                                @elseif($product->condition === 'seminovo')
                                    <span class="badge badge-info">Seminovo</span>
                                @else
                                    <span class="badge badge-warning">Usado</span>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between">
                                    <h4 class="text-neon mb-0">{{ number_format($product->price) }} pts</h4>
                                    <small class="text-muted">Estoque: <span class="stock-{{ $product->id }}">{{ $product->stock }}</span></small>
                                </div>

                                <button class="btn btn-neon btn-block mt-3 btn-redeem" 
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->price }}"
                                        @if(Auth::user()->descarte_points < $product->price) disabled @endif>
                                    <i class="fas fa-exchange-alt"></i> 
                                    @if(Auth::user()->descarte_points < $product->price)
                                        Pontos Insuficientes
                                    @else
                                        Resgatar
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center text-white mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <h4>😔 Nenhum produto disponível</h4>
            <p>Volte mais tarde!</p>
        </div>
    @endif
</div>

<button class="fab" title="Início" onclick="location.href='{{ route('logado') }}'">🏠</button>

<!-- MODAL DE CONFIRMAÇÃO -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-success">
                <h5 class="modal-title text-neon">
                    <i class="fas fa-exclamation-triangle"></i> Confirmar Resgate
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Você está prestes a resgatar:</p>
                <div class="alert alert-info">
                    <strong id="modalProductName"></strong><br>
                    <span class="text-neon" id="modalProductPrice"></span> pontos
                </div>
                <p class="text-warning">
                    <i class="fas fa-info-circle"></i> 
                    Esta ação não pode ser desfeita. Os pontos serão deduzidos imediatamente.
                </p>
                <p class="text-muted small">
                    Após o resgate, tire um print da confirmação e faça a solicitação pelo Suporte para receber seu produto.
                </p>
            </div>
            <div class="modal-footer border-success">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-neon" id="confirmRedeemBtn">
                    <i class="fas fa-check"></i> Confirmar Resgate
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE SUCESSO -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-success">
                <h5 class="modal-title text-neon">
                    <i class="fas fa-check-circle"></i> Resgate Realizado!
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="fas fa-trophy text-neon" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-neon">Parabéns!</h4>
                <p id="successMessage"></p>
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-camera"></i>
                    <strong>IMPORTANTE:</strong> Tire um print desta tela e faça a solicitação pelo Suporte para receber seu produto.
                </div>
                <p class="text-muted">
                    ID do Resgate: <strong class="text-neon" id="redemptionId"></strong>
                </p>
            </div>
            <div class="modal-footer border-success">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <a href="{{ route('historico') }}" class="btn btn-neon">
                    <i class="fas fa-history"></i> Ver Histórico
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- =============== ESTILOS CSS ================= -->
<!-- ============================================ -->
<style>

body {
    background: #000 !important;
    color: #fff;
    overflow-x: hidden;
}

/* ===== Fundo com iluminação verde ===== */
.neon-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 250px;
    pointer-events: none;
    background: radial-gradient(circle at top, rgba(0,255,150,0.4), transparent 70%);
    filter: blur(50px);
    z-index: -1;
}

/* ===== Caixa com pontos do usuário ===== */
.user-points-box {
    position: fixed;
    top: 20px;
    left: 20px;
    background: rgba(0,255,130,0.15);
    padding: 12px 20px;
    border: 1px solid rgba(0,255,130,0.4);
    border-radius: 8px;
    backdrop-filter: blur(5px);
    font-size: 1.1rem;
    z-index: 999;
    color: #b8ffdc;
}

.user-points-box i {
    color: #00ff88;
}

/* ===== Título neon ===== */
.text-neon {
    color: #00ff99;
    text-shadow: 0 0 10px #00ff99, 0 0 20px #00ff99;
}

/* ===== Cards ===== */
.product-card {
    background: #0a0a0a;
    border: 1px solid #111;
    border-radius: 12px;
    transition: 0.3s;
    overflow: hidden;
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 15px rgba(0,255,120,0.4);
}

/* ===== Imagem ===== */
.product-img img {
    width: 100%;
    height: 230px;
    object-fit: cover;
    transition: 0.3s;
}

.product-card:hover img {
    transform: scale(1.05);
}

/* ===== Badge ===== */
.badge-tag {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ff4747;
    padding: 6px 12px;
    color: #fff;
    border-radius: 6px;
    font-size: 0.85rem;
    z-index: 10;
}

/* ===== Botão Neon ===== */
.btn-neon {
    background: #00ff88;
    border: none;
    color: #000;
    font-weight: bold;
    transition: 0.3s;
}

.btn-neon:hover:not(:disabled) {
    background: #00cc6f;
    color: #000;
}

.btn-neon:disabled {
    background: #333;
    color: #666;
    cursor: not-allowed;
}

/* ===== FAB ===== */
.fab {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #00ff88;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,255,136,0.4);
    transition: 0.3s;
    z-index: 1000;
}

.fab:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0,255,136,0.6);
}

/* ===== Scrollbar neon ===== */
::-webkit-scrollbar {
    width: 8px;
}
::-webkit-scrollbar-track {
    background: #000;
}
::-webkit-scrollbar-thumb {
    background: #00ff88;
    border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
    background: #00cc6f;
}

/* ===== Modal customizado ===== */
.modal-content {
    border: 1px solid rgba(0,255,130,0.3);
}

.modal-header, .modal-footer {
    background: rgba(0,255,130,0.1);
}

</style>

<!-- ============================================ -->
<!-- =============== JAVASCRIPT ================= -->
<!-- ============================================ -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    let selectedProductId = null;

    // Setup CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Ao clicar em "Resgatar"
    $('.btn-redeem').on('click', function() {
        selectedProductId = $(this).data('product-id');
        const productName = $(this).data('product-name');
        const productPrice = $(this).data('product-price');

        $('#modalProductName').text(productName);
        $('#modalProductPrice').text(productPrice.toLocaleString('pt-BR'));

        $('#confirmModal').modal('show');
    });

    // Confirmar resgate
    $('#confirmRedeemBtn').on('click', function() {
        if (!selectedProductId) return;

        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processando...');

        $.ajax({
            url: `/produtos/${selectedProductId}/resgatar`,
            type: 'POST',
            success: function(response) {
                $('#confirmModal').modal('hide');

                // Atualiza pontos
                $('#userPoints').text(response.new_points);

                // Atualiza estoque
                const currentStock = parseInt($('.stock-' + selectedProductId).text());
                $('.stock-' + selectedProductId).text(currentStock - 1);

                // Desabilita botão se não tiver mais pontos
                const userPoints = parseFloat(response.new_points.replace('.', '').replace(',', '.'));
                $('.btn-redeem').each(function() {
                    const price = $(this).data('product-price');
                    if (userPoints < price) {
                        $(this).prop('disabled', true).html('<i class="fas fa-ban"></i> Pontos Insuficientes');
                    }
                });

                // Mostra modal de sucesso
                $('#successMessage').text(response.message);
                $('#redemptionId').text('#' + response.redemption_id);
                $('#successModal').modal('show');
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Erro ao processar resgate.');
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fas fa-check"></i> Confirmar Resgate');
            }
        });
    });
});
</script>

</body>
</html>