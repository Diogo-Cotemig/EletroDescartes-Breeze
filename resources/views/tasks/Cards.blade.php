<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @vite("resources/css/cards.css")
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/Eletro-DescarteLOGO.png') }}">
    <title>Grade de Produtos - EletroDescarte</title>
</head>
<body>

    <div class="section-header">
        <img src="{{ asset('img/Eletro-DescarteLOGO.png') }}" alt="Logo" height="100px">
        <h1 class="section-title"> Produtos em Destaque</h1>
        <p class="section-subtitle">Eletrônicos recondicionados e prontos para reuso</p>
    </div>

    <div class="product-grid">
        
        <!-- Produto 1: Notebook -->
        <div class="product-card">
            <div class="product-image-container">
                <span class="product-badge">Em Estoque</span>
                <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=300&fit=crop" 
                     alt="Notebook Dell" 
                     class="product-image">
            </div>
            <div class="product-info">
                <h3 class="product-name">Notebook Dell Inspiron 15</h3>
                <p class="product-description">Intel Core i5, 8GB RAM, SSD 256GB - Recondicionado</p>
                <button class="product-button">Conferir Detalhes</button>
            </div>
        </div>

        <!-- Produto 2: Smartphone -->
        <div class="product-card">
            <div class="product-image-container">
                <span class="product-badge">Novo</span>
                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=300&fit=crop" 
                     alt="Smartphone" 
                     class="product-image">
            </div>
            <div class="product-info">
                <h3 class="product-name">Smartphone Samsung Galaxy</h3>
                <p class="product-description">128GB, Câmera 48MP - Seminovo Premium</p>
                <button class="product-button">Conferir Detalhes</button>
            </div>
        </div>

        <!-- Produto 3: Monitor -->
        <div class="product-card">
            <div class="product-image-container">
                <span class="product-badge">Oferta</span>
                <img src="https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=400&h=300&fit=crop" 
                     alt="Monitor" 
                     class="product-image">
            </div>
            <div class="product-info">
                <h3 class="product-name">Monitor LED 24" Full HD</h3>
                <p class="product-description">LG UltraWide, HDMI, 75Hz - Recondicionado</p>
                <button class="product-button">Conferir Detalhes</button>
            </div>
        </div>

        <!-- Produto 4: Teclado -->
        <div class="product-card">
            <div class="product-image-container">
                <span class="product-badge">Popular</span>
                <img src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400&h=300&fit=crop" 
                     alt="Teclado Mecânico" 
                     class="product-image">
            </div>
            <div class="product-info">
                <h3 class="product-name">Teclado Mecânico RGB</h3>
                <p class="product-description">Switch Blue, Iluminação Customizável - Seminovo</p>
                <button class="product-button">Conferir Detalhes</button>
            </div>
        </div>

        <!-- Produto 5: Mouse -->
        <div class="product-card">
            <div class="product-image-container">
                <span class="product-badge">Em Estoque</span>
                <img src="https://images.unsplash.com/photo-1527814050087-3793815479db?w=400&h=300&fit=crop" 
                     alt="Mouse Gamer" 
                     class="product-image">
            </div>
            <div class="product-info">
                <h3 class="product-name">Mouse Gamer Logitech</h3>
                <p class="product-description">12.000 DPI, RGB, 6 Botões - Recondicionado</p>
                <button class="product-button">Conferir Detalhes</button>
            </div>
        </div>

        <!-- Produto 6: Headset -->
        <div class="product-card">
            <div class="product-image-container">
                <span class="product-badge">Novo</span>
                <img src="https://images.unsplash.com/photo-1484704849700-f032a568e944?w=400&h=300&fit=crop" 
                     alt="Headset" 
                     class="product-image">
            </div>
            <div class="product-info">
                <h3 class="product-name">Headset HyperX Cloud II</h3>
                <p class="product-description">7.1 Surround, Microfone Removível - Seminovo</p>
                <button class="product-button">Conferir Detalhes</button>
            </div>
        </div>

        <!-- Produto 7: Tablet -->
        <div class="product-card">
            <div class="product-image-container">
                <span class="product-badge">Oferta</span>
                <img src="https://images.unsplash.com/photo-1561154464-82e9adf32764?w=400&h=300&fit=crop" 
                     alt="Tablet" 
                     class="product-image">
            </div>
            <div class="product-info">
                <h3 class="product-name">Tablet iPad 8ª Geração</h3>
                <p class="product-description">32GB, Wi-Fi, Tela Retina 10.2" - Recondicionado</p>
                <button class="product-button">Conferir Detalhes</button>
            </div>
        </div>

        <!-- Produto 8: Webcam -->
        <div class="product-card">
            <div class="product-image-container">
                <span class="product-badge">Popular</span>
                <img src="https://images.unsplash.com/photo-1614624532983-4ce03382d63d?w=400&h=300&fit=crop" 
                     alt="Webcam" 
                     class="product-image">
            </div>
            <div class="product-info">
                <h3 class="product-name">Webcam Logitech C920</h3>
                <p class="product-description">Full HD 1080p, Microfone Estéreo - Seminovo</p>
                <button class="product-button">Conferir Detalhes</button>
            </div>
        </div>

    </div>

    <!-- BOTÃO FLUTUANTE DE VOLTAR -->
    <button class="fab" title="Voltar ao Início" onclick="voltarInicio()">🏠</button>

    <script>
        function voltarInicio() {
            window.location.href = '/';
        }
        // Adiciona interatividade aos botões
        document.querySelectorAll('.product-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const productName = this.closest('.product-card').querySelector('.product-name').textContent;
                alert(`🛒 Você selecionou: ${productName}\n\nRedirecionando para detalhes do produto...`);
            });
        });

        // Animação de entrada dos cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        entry.target.style.transition = 'all 0.6s ease';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, 100);
                    
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.product-card').forEach((card, index) => {
            card.style.transitionDelay = `${index * 0.1}s`;
            observer.observe(card);
        });
    </script>

</body>
</html>
