<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 @vite(['resources/css/Style.css', 'resources/js/Script.js', 'resources/js/server.js'])
  <title>EletroDescarte - Descarte Eletrônico Sustentável</title>
  <link rel="icon" type="image/png" href="{{ asset('public/img/Eletro-DescarteLOGO.png') }}">
</head>
<body style="overflow: auto;">
  <!-- HEADER -->
  <header class="navbar">
    <div class="logo"> EletroDescarte</div>
    <nav>
      <ul>
        <li><a href="#">Início</a></li>
        <li><a href="#sobre">Sobre</a></li>
        <li><a href="#" id="quemSomosBtn">Quem Somos</a></li>
        <li><a href="servicos">Serviços</a></li>
        <li><a href="{{ route('descartar') }}">Pontos de Descarte</a></li>
        <li><a href="#">Contato</a></li>
        <li><a href="#" id="supportBtn" class="support-btn">🔧 Suporte</a></li>
        <li><nav class="flex items-center justify-end gap-4">
        @if (Route::has('login'))
            @auth
                <a href="{{ route('logado') }}">Logado</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Registro</a>
                @endif
            @endauth
        @endif
    </nav></li>
      </ul>
    </nav>
    <div class="hamburger" id="hamburger">
    <span></span>
    <span></span>
    <span></span>
  </div>
  </header>

  <!-- MODAL QUEM SOMOS -->
  <div id="quemSomosModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Quem Nós Somos</h2>
        <button class="close-modal" id="closeModal">×</button>
      </div>
      <div class="modal-body">
        <div class="modal-section">
          <h3>🌱 Nossa História</h3>
          <p>A <strong>EletroDescarte</strong> nasceu em 2025 da necessidade urgente de combater o crescimento do lixo eletrônico no Brasil. Estamos no início da nossa caminhada, mas já demos passos importantes na conscientização sobre o descarte correto e na coleta seletiva de resíduos eletrônicos.</p>
        </div>
        <div class="highlight-box">
          <p><strong>💡 Nossa Visão:</strong> Ser a empresa líder em descarte responsável de eletrônicos no Brasil.</p>
        </div>
        <div class="modal-section">
          <h3>🎯 Nossos Valores</h3>
          <p><strong>Sustentabilidade:</strong> Preservação do meio ambiente.</p>
          <p><strong>Transparência:</strong> Informamos todo o processo.</p>
          <p><strong>Inovação:</strong> Tecnologias de ponta.</p>
        </div>
      </div>
    </div>
  </div>
  <!-- MODAL LOGIN -->
      <!-- Register Form -->
      <div id="registerTab" class="tab-content">
        <form class="login-form" id="registerForm">
          <div class="input-group">
            <label for="registerName">👤 Nome completo</label>
            <input type="text" id="registerName" name="name" placeholder="Digite seu nome completo" required="">
          </div>
          <div class="input-group">
            <label for="registerEmail">📧 E-mail</label>
            <input type="email" id="registerEmail" name="email" placeholder="seu@email.com" required="">
          </div>
          <div class="input-group">
            <label for="registerPassword">🔒 Senha</label>
            <div class="password-wrapper">
              <input type="password" id="registerPassword" name="password" placeholder="Mínimo 6 caracteres" required="">
              <button type="button" class="toggle-password" data-target="registerPassword">👁️</button>
            </div>
          </div>
          <div class="input-group">
            <label for="confirmPassword">🔒 Confirmar senha</label>
            <div class="password-wrapper">
              <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Digite a senha novamente" required="">
              <button type="button" class="toggle-password" data-target="confirmPassword">👁️</button>
            </div>
          </div>
          <div class="form-options">
            <label class="checkbox-wrapper">
              <input type="checkbox" id="acceptTerms" required="">
              <span class="checkmark">✓</span>
              Aceito os <a href="#">termos de uso</a>
            </label>
          </div>
          <button type="submit" class="auth-btn primary">Criar conta</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- MODAL SUPORTE TÉCNICO -->
<div id="supportModal" class="modal">
  <div class="modal-content support-modal">
    <div class="modal-header">
      <h2 class="modal-title">🔧 Assistência Técnica</h2>
      <button class="close-modal" id="closeSupportModal">&times;</button>
    </div>
    <div class="modal-body">
      <div class="support-intro">
        <p>Descreva seu problema e nossa equipe entrará em contato em até 24 horas.</p>
      </div>

      <form class="support-form" id="supportForm">
        <div class="form-row">
          <div class="input-group">
            <label for="supportName">👤 Nome completo</label>
            <input type="text" id="supportName" name="name" placeholder="Digite seu nome" required>
          </div>
          <div class="input-group">
            <label for="supportEmail">📧 E-mail</label>
            <input type="email" id="supportEmail" name="email" placeholder="seu@email.com" required>
          </div>
        </div>

        <div class="form-row">
          <div class="input-group">
            <label for="supportPhone">📱 Telefone</label>
            <input type="tel" id="supportPhone" name="phone" placeholder="(00) 00000-0000">
          </div>
          <div class="input-group">
            <label for="supportCategory">📋 Categoria do problema</label>
            <select id="supportCategory" name="category" required>
              <option value="">Selecione uma categoria</option>
              <option value="coleta">Problema na Coleta</option>
              <option value="agendamento">Agendamento de Serviço</option>
              <option value="equipamento">Dúvida sobre Equipamento</option>
              <option value="certificado">Certificado de Descarte</option>
              <option value="pagamento">Questões de Pagamento</option>
              <option value="outro">Outros</option>
            </select>
          </div>
        </div>

        <div class="input-group">
          <label for="supportPriority">⚡ Prioridade</label>
          <div class="priority-options">
            <label class="radio-wrapper">
              <input type="radio" name="priority" value="baixa" checked>
              <span class="radio-mark"></span>
              🟢 Baixa
            </label>
            <label class="radio-wrapper">
              <input type="radio" name="priority" value="media">
              <span class="radio-mark"></span>
              🟡 Média
            </label>
            <label class="radio-wrapper">
              <input type="radio" name="priority" value="alta">
              <span class="radio-mark"></span>
              🔴 Alta
            </label>
            <label class="radio-wrapper">
              <input type="radio" name="priority" value="urgente">
              <span class="radio-mark"></span>
              🚨 Urgente
            </label>
          </div>
        </div>

        <div class="input-group">
          <label for="supportDescription">📝 Descrição detalhada do problema</label>
          <textarea id="supportDescription" name="description" rows="5"
                    placeholder="Descreva seu problema com o máximo de detalhes possível..." required></textarea>
        </div>

        <div class="input-group">
          <label for="supportAttachment">📎 Anexar arquivos (opcional)</label>
          <input type="file" id="supportAttachment" name="attachment"
                 accept="image/*,.pdf,.doc,.docx" multiple>
          <small class="file-info">Formatos aceitos: JPG, PNG, PDF, DOC, DOCX (máx. 10MB)</small>
        </div>

        <div class="form-options">
          <label class="checkbox-wrapper">
            <input type="checkbox" id="supportNotifications" checked>
            <span class="checkmark">✓</span>
            Receber notificações por e-mail sobre o andamento
          </label>
        </div>

        <button type="submit" class="auth-btn primary">Enviar Solicitação</button>
      </form>

      <div class="support-contacts">
        <h4>Outros canais de atendimento:</h4>
        <div class="contact-options">
          <a href="tel:+5531000000000" class="contact-option">
            📞 (31) 0000-0000
          </a>
          <a href="mailto:suporte@eletrodescarte.com.br" class="contact-option">
            📧 suporte@eletrodescarte.com.br
          </a>
          <a href="#" class="contact-option">
            💬 Chat Online
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="hero-content">
      <h1>Descarte Eletrônico</h1>
      <p>Contribua para um futuro sustentável.<br>Descarte seu lixo eletrônico de forma correta.</p>
      <div class="buttons">
        <a href="#" class="btn primary">Saiba Mais</a>
        <a href="" id="Descart" class="btn secondary">Deseja descartar ?</a>
      </div>
    </div>
    <div class="hero-image">
      <div class="hero-particles">
  <!-- Partículas serão adicionadas via CSS -->
</div>
      <img src="https://via.placeholder.com/500x400/0af/fff?text=Lixo+Eletrônico" alt="Lixo Eletrônico">
    </div>
  </section>

  <!-- ABOUT US SECTION -->
  <section class="about-us">
    <div class="about-container">
      <!-- Imagem posicionada acima do título -->
      <div class="about-image">
        <img src="{{ asset('img/Imagem-Homem-Servico.png') }}" alt="Homem trabalhando com serviços eletrônicos">
      </div>

      <div class="about-content">
        <h2 class="section-title">Nossa Missão</h2>
        <p class="section-subtitle">Transformando lixo eletrônico em um futuro sustentável.</p>
        <p class="about-text">
            A quantidade de lixo eletrônico no mundo cresce a cada ano, e o descarte incorreto causa danos irreversíveis ao nosso meio ambiente. Materiais tóxicos se infiltram no solo e na água, prejudicando ecossistemas e a saúde humana.
        </p>
        <p class="about-text">
            É por isso que a <strong>EletroDescarte</strong> existe. Nossa missão é oferecer uma solução eficiente, segura e responsável para o descarte de eletrônicos, garantindo que cada componente seja reciclado ou reutilizado da maneira correta. Acreditamos que a tecnologia e a sustentabilidade podem e devem caminhar juntas.
        </p>
<!--Mudança Diogo
  <img src="{{ asset('img/Eletro-DescarteLOGO.png') }}" alt="Logo EletroDescarte" class="minha-imagem">
        <br>
        <a href="#" class="btn-primary">Conheça a EletroDescarte</a>
-->



  <div class="logo-container">
  <img src="{{ asset('public/img/Eletro-DescarteLOGO.png') }}" alt="Logo EletroDescarte" class="minha-imagem">
  <br>
  <a href="#" class="btn-primary">Conheça a EletroDescarte</a>
</div>

      </div>
    </div>
  </section>
  <section class="partnerships">
  <div class="partnerships-container">
    <div class="partnerships-header">
      <h2 class="section-title">Nossas Parcerias</h2>
      <p class="section-subtitle">Trabalhando juntos por um futuro mais sustentável</p>
    </div>

    <div class="partnerships-content">
      <div class="partnerships-text">
        <p class="partnerships-description">
          A EletroDescarte está começando sua trajetória com foco na reciclagem de lixo eletrônico. Estamos em fase inicial de construção de parcerias com empresas, órgãos públicos e também com a comunidade. Nosso objetivo é desenvolver projetos de coleta seletiva e iniciar campanhas de conscientização sobre a importância do descarte correto de resíduos eletrônicos.
        </p>

        <div class="partnership-stats">
          <div class="stat-item">
            <div class="stat-number">0</div>
            <div class="stat-label">Empresas Parceiras</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">0</div>
            <div class="stat-label">Órgãos Públicos</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">0</div>
            <div class="stat-label">Lixo Eletrônico Coletado</div>
          </div>
        </div>

        <div class="partnership-types">
          <div class="partnership-type">
            <div class="type-icon">🏢</div>
            <h4>Empresas Privadas</h4>
            <p>Parcerias com corporações para descarte responsável de equipamentos corporativos</p>
          </div>
          <div class="partnership-type">
            <div class="type-icon">🏛️</div>
            <h4>Órgãos Públicos</h4>
            <p>Colaboração em projetos de conscientização e coleta seletiva municipal</p>
          </div>
          <div class="partnership-type">
            <div class="type-icon">♻️</div>
            <h4>Centros de Reciclagem</h4>
            <p>Rede especializada para processamento adequado dos materiais coletados</p>
          </div>
        </div>
      </div>

      <div class="partnerships-visual">
        <div class="handshake-container">
          <div class="handshake-icon">
            <svg viewBox="0 0 200 150" class="handshake-svg">
              <defs>
                <linearGradient id="handGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" style="stop-color:#00ff88"></stop>
                  <stop offset="100%" style="stop-color:#0af"></stop>
                </linearGradient>
              </defs>
              <!-- Handshake illustration -->
              <path d="M50 80 Q70 60 100 75 Q130 60 150 80 Q130 100 100 85 Q70 100 50 80" fill="url(#handGradient)" opacity="0.8"></path>
              <circle cx="65" cy="70" r="15" fill="url(#handGradient)" opacity="0.6"></circle>
              <circle cx="135" cy="70" r="15" fill="url(#handGradient)" opacity="0.6"></circle>
              <path d="M80 50 L120 50" stroke="url(#handGradient)" stroke-width="3" opacity="0.7"></path>
            </svg>
          </div>
          <div class="partnership-glow"></div>
        </div>

        <div class="floating-elements">
          <div class="floating-element" style="--delay: 0s">💼</div>
          <div class="floating-element" style="--delay: 1s">🌱</div>
          <div class="floating-element" style="--delay: 2s">🤝</div>
          <div class="floating-element" style="--delay: 3s">📱</div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- CATEGORIES SECTION -->
<section class="categories" id="Descart2">
  <div class="categories-container">
    <div class="categories-header">
      <h2 class="section-title">Categorias de descarte.</h2>
      <p class="section-subtitle">Descarte cada tipo de eletrônico no local correto</p>
    </div>

    <div class="categories-grid">
      <div class="category-card" data-category="perifericos">
        <div class="category-icon">
          <svg viewBox="0 0 100 80" class="category-svg">
            <!-- Teclado -->
            <rect x="10" y="25" width="60" height="30" rx="3" fill="none" stroke="currentColor" stroke-width="2"></rect>
            <g fill="currentColor">
              <rect x="15" y="30" width="4" height="4" rx="1"></rect>
              <rect x="22" y="30" width="4" height="4" rx="1"></rect>
              <rect x="29" y="30" width="4" height="4" rx="1"></rect>
              <rect x="36" y="30" width="4" height="4" rx="1"></rect>
              <rect x="43" y="30" width="4" height="4" rx="1"></rect>
              <rect x="50" y="30" width="4" height="4" rx="1"></rect>
              <rect x="57" y="30" width="4" height="4" rx="1"></rect>

              <rect x="15" y="37" width="4" height="4" rx="1"></rect>
              <rect x="22" y="37" width="4" height="4" rx="1"></rect>
              <rect x="29" y="37" width="4" height="4" rx="1"></rect>
              <rect x="36" y="37" width="4" height="4" rx="1"></rect>
              <rect x="43" y="37" width="4" height="4" rx="1"></rect>
              <rect x="50" y="37" width="4" height="4" rx="1"></rect>

              <rect x="15" y="44" width="15" height="4" rx="1"></rect>
              <rect x="35" y="44" width="15" height="4" rx="1"></rect>
              <rect x="55" y="44" width="6" height="4" rx="1"></rect>
            </g>
            <!-- Mouse -->
            <ellipse cx="80" cy="40" rx="8" ry="12" fill="none" stroke="currentColor" stroke-width="2"></ellipse>
            <circle cx="80" cy="35" r="1.5" fill="currentColor"></circle>
            <line x1="80" y1="28" x2="80" y2="32" stroke="currentColor" stroke-width="1"></line>
          </svg>
        </div>
        <h3 class="category-title">PERIFÉRICOS</h3>
        <p class="category-description">Teclados, mouses, fones de ouvido, webcams e outros acessórios</p>
        <div class="category-hover-effect"></div>
      </div>

      <div class="category-card" data-category="hardware">
        <div class="category-icon">
          <svg viewBox="0 0 100 80" class="category-svg">
            <!-- CPU -->
            <rect x="20" y="15" width="35" height="50" rx="2" fill="none" stroke="currentColor" stroke-width="2"></rect>
            <rect x="25" y="20" width="25" height="15" rx="1" fill="currentColor" opacity="0.3"></rect>
            <rect x="25" y="40" width="25" height="20" rx="1" fill="none" stroke="currentColor" stroke-width="1"></rect>

            <!-- Ventilador -->
            <circle cx="42" cy="50" r="8" fill="none" stroke="currentColor" stroke-width="1"></circle>
            <path d="M42 45 L47 50 L42 55 L37 50 Z" fill="currentColor" opacity="0.6"></path>

            <!-- Placa mãe -->
            <rect x="60" y="25" width="25" height="30" rx="2" fill="none" stroke="currentColor" stroke-width="2"></rect>
            <rect x="65" y="30" width="5" height="5" fill="currentColor"></rect>
            <rect x="72" y="30" width="5" height="5" fill="currentColor"></rect>
            <rect x="79" y="30" width="3" height="8" fill="currentColor"></rect>
            <rect x="65" y="40" width="15" height="3" fill="currentColor"></rect>
            <rect x="65" y="45" width="10" height="3" fill="currentColor"></rect>
          </svg>
        </div>
        <h3 class="category-title">HARDWARE</h3>
        <p class="category-description">CPUs, placas-mãe, memórias RAM, HDs e componentes internos</p>
        <div class="category-hover-effect"></div>
      </div>

      <div class="category-card" data-category="celulares">
        <div class="category-icon">
          <svg viewBox="0 0 100 80" class="category-svg">
            <!-- Smartphone -->
            <rect x="35" y="10" width="30" height="60" rx="8" fill="none" stroke="currentColor" stroke-width="2"></rect>
            <rect x="38" y="18" width="24" height="35" rx="2" fill="currentColor" opacity="0.2"></rect>
            <circle cx="50" cy="62" r="4" fill="none" stroke="currentColor" stroke-width="2"></circle>
            <rect x="45" y="14" width="10" height="2" rx="1" fill="currentColor"></rect>

            <!-- Linhas da tela -->
            <line x1="40" y1="22" x2="60" y2="22" stroke="currentColor" stroke-width="1" opacity="0.5"></line>
            <line x1="40" y1="26" x2="55" y2="26" stroke="currentColor" stroke-width="1" opacity="0.5"></line>
            <line x1="40" y1="30" x2="58" y2="30" stroke="currentColor" stroke-width="1" opacity="0.5"></line>
          </svg>
        </div>
        <h3 class="category-title">CELULARES</h3>
        <p class="category-description">Smartphones, tablets, carregadores e acessórios móveis</p>
        <div class="category-hover-effect"></div>
      </div>

      <div class="category-card" data-category="telas">
        <div class="category-icon">
          <svg viewBox="0 0 100 80" class="category-svg">
            <!-- Monitor -->
            <rect x="15" y="15" width="70" height="40" rx="3" fill="none" stroke="currentColor" stroke-width="2"></rect>
            <rect x="20" y="20" width="60" height="30" rx="2" fill="currentColor" opacity="0.15"></rect>

            <!-- Base do monitor -->
            <rect x="45" y="55" width="10" height="8" rx="1" fill="currentColor"></rect>
            <rect x="35" y="63" width="30" height="3" rx="1" fill="currentColor"></rect>

            <!-- Conteúdo da tela -->
            <rect x="25" y="25" width="15" height="8" fill="currentColor" opacity="0.4"></rect>
            <line x1="25" y1="37" x2="70" y2="37" stroke="currentColor" stroke-width="1" opacity="0.3"></line>
            <line x1="25" y1="41" x2="60" y2="41" stroke="currentColor" stroke-width="1" opacity="0.3"></line>
            <line x1="25" y1="45" x2="65" y2="45" stroke="currentColor" stroke-width="1" opacity="0.3"></line>
          </svg>
        </div>
        <h3 class="category-title">TELAS</h3>
        <p class="category-description">Monitores, TVs, displays e equipamentos de vídeo</p>
        <div class="category-hover-effect"></div>
      </div>
    </div>

    <div class="categories-cta">
      <p class="cta-text">Não sabe onde descartar seu eletrônico?</p>
      <a href="pontos-descarte.html" class="btn cta-button">Encontrar Ponto de Coleta</a>
    </div>
  </div>
</section>

<!-- FOOTER - ADICIONAR APÓS A SEÇÃO CATEGORIES -->
<footer class="footer">
  <div class="footer-container">
    <!-- Footer Main Content -->
    <div class="footer-content">

      <!-- Company Info -->
      <div class="footer-section">
        <div class="footer-logo">
          <span class="logo-icon">♻️</span>
          <span class="logo-text">EletroDescarte</span>
        </div>
        <p class="footer-description">
          Transformando lixo eletrônico em um futuro sustentável. Descarte responsável para preservar o meio ambiente.
        </p>
        <div class="footer-stats">
          <div class="stat">
            <span class="stat-number">0</span>
            <span class="stat-text">Toneladas Coletadas</span>
          </div>
          <div class="stat">
            <span class="stat-number">0</span>
            <span class="stat-text">Empresas Parceiras</span>
          </div>
        </div>
      </div>

      <!-- Navigation Links -->
      <div class="footer-section">
        <h3 class="footer-title">Navegação</h3>
        <ul class="footer-links">
          <li><a href="#">Início</a></li>
          <li><a href="#sobre">Sobre Nós</a></li>
          <li><a href="#servicos">Serviços</a></li>
          <li><a href="pontos-descarte.html">Pontos de Descarte</a></li>
          <li><a href="#">Blog</a></li>
        </ul>
      </div>

      <!-- Services -->
      <div class="footer-section">
        <h3 class="footer-title">Serviços</h3>
        <ul class="footer-links">
          <li><a href="#">Coleta Domiciliar</a></li>
          <li><a href="#">Coleta Empresarial</a></li>
          <li><a href="#">Consultoria Ambiental</a></li>
          <li><a href="#">Certificados de Descarte</a></li>
          <li><a href="#">Parcerias</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="footer-section">
        <h3 class="footer-title">Contato</h3>
        <div class="contact-info">
          <div class="contact-item">
            <span class="contact-icon">📞</span>
            <span class="contact-text">(31) 0000-0000</span>
          </div>
          <div class="contact-item">
            <span class="contact-icon">📧</span>
            <span class="contact-text">eletrodescarte@gmail.com.br</span>
          </div>
          <div class="contact-item">
            <span class="contact-icon">📍</span>
            <span class="contact-text">Minas Gerais, MG - Brasil</span>
          </div>
          <div class="contact-item">
            <span class="contact-icon">🕒</span>
            <span class="contact-text">Seg - Sex: </span>
          </div>
        </div>

        <!-- Social Media -->
        <div class="social-media">
          <h4 class="social-title">Siga-nos</h4>
          <div class="social-links">
            <a href="#" class="social-link facebook" aria-label="Facebook">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
              </svg>
            </a>
            <a href="#" class="social-link tiktok" aria-label="TikTok">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"></path>
              </svg>
            </a>
            <a href="#" class="social-link instagram" aria-label="Instagram">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Newsletter Section -->
    <div class="newsletter-section">
      <div class="newsletter-content">
        <div class="newsletter-text">
          <h3>📩 Receba nossas novidades</h3>
          <p>Fique por dentro das últimas dicas de descarte sustentável e novidades da EletroDescarte</p>
        </div>
        <form class="newsletter-form">
          <input type="email" placeholder="Seu melhor e-mail" class="newsletter-input" required="">
          <button type="submit" class="newsletter-btn">Inscrever-se</button>
        </form>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <div class="footer-bottom-content">
        <div class="copyright">
          <p>© 2025 EletroDescarte. Todos os direitos reservados.</p>
        </div>
        <div class="footer-bottom-links">
          <a href="#">Política de Privacidade</a>
          <span class="separator">|</span>
          <a href="#">Termos de Uso</a>
          <span class="separator">|</span>
          <a href="#">Cookies</a>
        </div>
      </div>

      <!-- Decorative Element -->
      <div class="footer-decoration">
        <div class="decoration-line"></div>
        <div class="decoration-icon">♻️</div>
        <div class="decoration-line"></div>
      </div>
    </div>
  </div>

  <!-- Background Effects -->
  <div class="footer-bg-effect"></div>
</footer>

  <script>
    // Modal
    const quemSomosBtn = document.getElementById('quemSomosBtn');
    const quemSomosModal = document.getElementById('quemSomosModal');
    const closeModal = document.getElementById('closeModal');

    quemSomosBtn.addEventListener('click', function(e) {
      e.preventDefault();
      quemSomosModal.classList.add('show');
      document.body.style.overflow = 'hidden';
    });

    closeModal.addEventListener('click', function() {
      quemSomosModal.classList.remove('show');
      document.body.style.overflow = 'auto';
    });

    quemSomosModal.addEventListener('click', function(e) {
      if (e.target === quemSomosModal) {
        quemSomosModal.classList.remove('show');
        document.body.style.overflow = 'auto';
      }
    });
    // Modal Login
const loginBtn = document.getElementById('loginBtn');
const loginModal = document.getElementById('loginModal');
const closeLoginModal = document.getElementById('closeLoginModal');

loginBtn.addEventListener('click', function(e) {
  e.preventDefault();
  loginModal.classList.add('show');
  document.body.style.overflow = 'hidden';
});

closeLoginModal.addEventListener('click', function() {
  loginModal.classList.remove('show');
  document.body.style.overflow = 'auto';
});

loginModal.addEventListener('click', function(e) {
  if (e.target === loginModal) {
    loginModal.classList.remove('show');
    document.body.style.overflow = 'auto';
  }
});

// Login Tabs
const tabButtons = document.querySelectorAll('.tab-button');
const tabContents = document.querySelectorAll('.tab-content');

tabButtons.forEach(button => {
  button.addEventListener('click', () => {
    const targetTab = button.getAttribute('data-tab');

    tabButtons.forEach(btn => btn.classList.remove('active'));
    tabContents.forEach(content => content.classList.remove('active'));

    button.classList.add('active');
    document.getElementById(targetTab + 'Tab').classList.add('active');
  });
});

// Toggle Password
const togglePasswordBtns = document.querySelectorAll('.toggle-password');

togglePasswordBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    const targetId = btn.getAttribute('data-target');
    const passwordInput = document.getElementById(targetId);

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      btn.textContent = '🙈';
    } else {
      passwordInput.type = 'password';
      btn.textContent = '👁️';
    }
  });
});

// Form Submissions
document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const email = this.querySelector('#loginEmail').value;
  alert(`Login realizado! E-mail: ${email}`);
  loginModal.classList.remove('show');
  document.body.style.overflow = 'auto';
  this.reset();
});



document.getElementById('registerForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const password = this.querySelector('#registerPassword').value;
  const confirmPassword = this.querySelector('#confirmPassword').value;

  if (password !== confirmPassword) {
    alert('As senhas não coincidem!');
    return;
  }

  alert('Cadastro realizado com sucesso!');
  loginModal.classList.remove('show');
  document.body.style.overflow = 'auto';
  this.reset();
});
  </script>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>

  // Modal Suporte
const supportBtn = document.getElementById('supportBtn');
const supportModal = document.getElementById('supportModal');
const closeSupportModal = document.getElementById('closeSupportModal');

supportBtn.addEventListener('click', function(e) {
  e.preventDefault();
  supportModal.classList.add('show');
  document.body.style.overflow = 'hidden';
});

closeSupportModal.addEventListener('click', function() {
  supportModal.classList.remove('show');
  document.body.style.overflow = 'auto';
});

document.getElementById('supportForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);

    try {
        const response = await fetch('/chamado', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert(`✅ ${result.message}\nProtocolo: ${result.data.protocol}`);
            e.target.reset();
        } else {
            alert(`❌ ${result.message}`);
            console.error(result.errors);
        }
    } catch (error) {
        alert('❌ Erro ao enviar o chamado. Tente novamente.');
        console.error(error);
    }
});

supportModal.addEventListener('click', function(e) {
  if (e.target === supportModal) {
    supportModal.classList.remove('show');
    document.body.style.overflow = 'auto';
  }
});

// Máscara para telefone
document.getElementById('supportPhone').addEventListener('input', function(e) {
  let value = e.target.value.replace(/\D/g, '');
  if (value.length <= 11) {
    value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
    e.target.value = value;
  }
});

// Form de suporte
document.getElementById('supportForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);
  const data = {
    name: formData.get('name'),
    email: formData.get('email'),
    phone: formData.get('phone'),
    category: formData.get('category'),
    priority: formData.get('priority'),
    description: formData.get('description'),
    notifications: formData.has('supportNotifications')
  };

  // Simular envio
  const submitBtn = this.querySelector('button[type="submit"]');
  submitBtn.textContent = 'Enviando...';
  submitBtn.disabled = true;

  setTimeout(() => {
    alert('Solicitação enviada com sucesso! Protocolo: #' + Math.floor(Math.random() * 100000));
    supportModal.classList.remove('show');
    document.body.style.overflow = 'auto';
    this.reset();
    submitBtn.textContent = 'Enviar Solicitação';
    submitBtn.disabled = false;
  }, 2000);
});

// Contatos alternativos
document.querySelector('.contact-option[href^="mailto"]').addEventListener('click', function(e) {
  if (!e.target.href.includes('mailto:')) {
    e.preventDefault();
    alert('E-mail copiado: suporte@eletrodescarte.com.br');
  }
});

document.querySelector('.contact-option[href="#"]').addEventListener('click', function(e) {
  e.preventDefault();
  alert('Chat online será aberto em breve!');
});
// Menu hamburger MELHORADO
const hamburger = document.getElementById('hamburger');
const navMenu = document.querySelector('.navbar ul');

if (hamburger && navMenu) {
  hamburger.addEventListener('click', function() {
    this.classList.toggle('active');
    navMenu.classList.toggle('active');

    // Previne scroll do body quando menu está aberto
    if (navMenu.classList.contains('active')) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = 'auto';
    }
  });

  // Fecha o menu quando clicar em um link
  navMenu.addEventListener('click', function(e) {
    if (e.target.tagName === 'A') {
      hamburger.classList.remove('active');
      navMenu.classList.remove('active');
      document.body.style.overflow = 'auto';
    }
  });

  // Fecha o menu quando clicar fora dele
  document.addEventListener('click', function(e) {
    if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
      hamburger.classList.remove('active');
      navMenu.classList.remove('active');
      document.body.style.overflow = 'auto';
    }
  });
}
</script>

</body></html>
