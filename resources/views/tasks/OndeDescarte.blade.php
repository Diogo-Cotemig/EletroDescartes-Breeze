<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Descarte Inteligente</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
      <link rel="icon" type="image/png" href="{{ asset('img/Eletro-DescarteLOGO.png') }}">
    @vite(['resources/css/Ondedescarte.css'])
</head>
<body>

    <div class="mapa-container">
        <div id="mapa"></div>
        <div id="distancia-destino" class="distancia-tag"></div>
    </div>

    <img id="logoEle" src="{{ asset('img/logo.png') }}" alt="Logo Eletro Descarte" class="logo-site"/>

    <div class="main-content">
        <h2 class="title-header">Como deseja realizar o descarte?</h2>
        <div class="options-grid">
           @guest
    <!-- SE NÃO ESTIVER LOGADO → REDIRECIONAR PARA LOGIN -->
    <a href="{{ route('login') }}?aviso=login_required" class="option-card" data-icon="truck">
        <span class="option-text">Buscar no Local</span>
    </a>
@endguest

@auth
    <!-- SE ESTIVER LOGADO → ABRE O MODAL NORMALMENTE -->
    <div class="option-card" onclick="abrirModal('buscar')" data-icon="truck">
        <span class="option-text">Buscar no Local</span>
    </div>
@endauth
            <div class="option-card" onclick="abrirModal('ponto')" data-icon="bin">
                <span class="option-text">Ponto de coleta mais próximo</span>
            </div>
            <div class="option-card" onclick="abrirRota()" data-icon="office">
                <span class="option-text">Levar na empresa</span>
            </div>
        </div>
    </div>

<div class="modal" id="modal">
    <div class="modal-wrapper">

        <!-- LEFT: MODAL ORIGINAL -->
        <div class="modal-content" id="modalContent"></div>

        <!-- RIGHT: LOGIN -->
        <div class="login-container">

          @guest
<div class="modal-overlay-warning">
    <p>⚠️ É preciso logar para realizar essa ação.</p>

    <a href="{{ route('login') }}">
        <button class="login-btn">Entrar</button>
    </a>

    <a href="{{ route('register') }}" class="create-account">Criar conta</a>
</div>
@endguest

        </div>

    </div>
</div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
      function abrirRota() {
    const destino = sessionStorage.getItem('endereco');

    if (!destino) {
        alert("Destino não encontrado. Volte e selecione um ponto de coleta.");
        return;
    }

    const url = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(destino)}`;
    window.open(url, "_blank");
}
        // --- 1. CONFIGURAÇÃO DE VALOR E TAXAS ---
        const TAXA_BASE = 20.00;
        const CUSTO_POR_KM = 1.50;
        const CUSTO_POR_ITEM = 5.00;

        function calcularValorTotal() {
            const distanciaStr = sessionStorage.getItem('distancia');
            const distanciaKm = distanciaStr ? parseFloat(distanciaStr) : 0;
            let valorDistancia = distanciaKm > 0 ? distanciaKm * CUSTO_POR_KM : 0;

            const itensSelecionados = document.querySelectorAll('#form-coleta input[name="item"]:checked').length;
            const valorItens = itensSelecionados * CUSTO_POR_ITEM;

            let valorFinal = TAXA_BASE + valorDistancia + valorItens;
            return {
                valorNumerico: parseFloat(valorFinal.toFixed(2)),
                valorFormatado: valorFinal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })
            };
        }

        // --- 2. ESTRUTURA DO MODAL ---
        const originalModalContent = `
            <button class="close-btn" onclick="fecharModal()">×</button>
            <div class="form-header">
                <h3>Agendamento de Coleta no Local</h3>
                <p>O valor estimado do serviço é:
                    <span id="valorCalculado" style="color: var(--color-neon-green); font-weight: 700; font-size: 1.1em;">R$ 0,00</span>
                </p>
            </div>
            <form id="form-coleta" onsubmit="enviarAgendamento(event)">
                <div class="form-section">
                    <h4>1. Itens a Descartar *</h4>
                    <div class="item-selector-grid" id="itemSelectorGrid">
                        <label><input type="checkbox" name="item" value="Hardware" onchange="atualizarValor()"> Hardware</label>
                        <label><input type="checkbox" name="item" value="Eletrodomésticos" onchange="atualizarValor()"> Eletrodomésticos</label>
                        <label><input type="checkbox" name="item" value="Monitores" onchange="atualizarValor()"> Monitores</label>
                        <label><input type="checkbox" name="item" value="Computador" onchange="atualizarValor()"> Computador</label>
                        <label><input type="checkbox" name="item" value="Pilhas/Baterias" onchange="atualizarValor()"> Pilhas/Baterias</label>
                        <label><input type="checkbox" name="item" value="Cabos/Fios" onchange="atualizarValor()"> Cabos/Fios</label>
                    </div>
                    <textarea name="observacao_itens" placeholder="Observações sobre os itens (ex: volume, estado, quantidade)."></textarea>
                </div>

                <div class="form-section">
                    <h4>2. Dados do Responsável</h4>
                   <input type="tel" id="telefone" name="telefone" placeholder="Telefone de Contato *" required>
                   @auth
    <input type="text" name="nome_completo" value="{{ Auth::user()->name }}" readonly>
    <input type="email" name="email" value="{{ Auth::user()->email }}" readonly>
@endauth

@guest
    <input type="text" name="nome_completo" placeholder="Nome Completo *" required>
    <input type="email" name="email" placeholder="E-mail (Para confirmação) *" required>
@endguest
                </div>

                <div class="form-section">
                    <h4>3. Agendamento</h4>
                    <input type="date" name="data_coleta" required>
                    <select name="periodo_preferencia" required>
                        <option value="" disabled selected>Período de Preferência *</option>
                        <option value="manha">Manhã (8h - 12h)</option>
                        <option value="tarde">Tarde (13h - 17h)</option>
                        <option value="comercial">Horário Comercial (8h - 17h)</option>
                    </select>
                </div>

                <input type="hidden" name="valor_coleta" id="inputValorColeta">

                <button type="submit" class="submit-button">Confirmar Agendamento e Prosseguir</button>
            </form>
        `;

        function atualizarValor() {
            const { valorNumerico, valorFormatado } = calcularValorTotal();
            const valorDisplay = document.getElementById('valorCalculado');
            const valorInput = document.getElementById('inputValorColeta');
            if (valorDisplay) valorDisplay.innerText = valorFormatado;
            if (valorInput) valorInput.value = valorNumerico;
        }

        // --- 3. MAPA ---
        let tipoFluxo = null;
        const map = L.map('mapa').setView([-19.9191, -43.9386], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const endereco = sessionStorage.getItem('endereco');
        const rotaJson = sessionStorage.getItem('rota');
        const distancia = sessionStorage.getItem('distancia');

        if (rotaJson) {
            try {
                const rota = JSON.parse(rotaJson);
                const routeLayer = L.geoJSON(rota, { style: { color: "#00ff80", weight: 5 } }).addTo(map);
                map.fitBounds(routeLayer.getBounds());
                const startPoint = rota.coordinates[0];
                const endPoint = rota.coordinates[rota.coordinates.length - 1];
                L.marker([startPoint[1], startPoint[0]]).addTo(map).bindPopup("Origem");
                L.marker([endPoint[1], endPoint[0]]).addTo(map).bindPopup("Destino");
                document.getElementById("distancia-destino").innerText = `${distancia} km`;
            } catch (e) {
                console.error("Erro ao carregar a rota:", e);
            }
        }

        // --- 4. FLUXO DO MODAL ---
        function abrirModal(tipo) {
            tipoFluxo = tipo;
            const modalContent = document.getElementById("modalContent");
            if (tipo === 'buscar') {
                 modalContent.innerHTML = originalModalContent;
                 atualizarValor();
                 
            } else if (tipo === 'ponto') {
                 modalContent.innerHTML = pontoColetaModal;
            }
            document.getElementById("modal").style.display = "flex";
        }

        function fecharModal() {
            document.getElementById("modal").style.display = "none";
        }

        // --- 5. ENVIO DE AGENDAMENTO (CORRIGIDO) ---
        function enviarAgendamento(event) {
            event.preventDefault();
            const form = document.getElementById('form-coleta');
            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const itensSelecionados = Array.from(form.querySelectorAll('input[name="item"]:checked'))
                                           .map(input => input.value);
            if (itensSelecionados.length === 0) {
                alert("Por favor, selecione pelo menos um item para descarte.");
                return;
            }

            const valorColeta = formData.get('valor_coleta');
            const dadosEnvioBD = {
                nome_completo: formData.get('nome_completo'),
                telefone: formData.get('telefone'),
                email: formData.get('email'),
                itens_descartados: itensSelecionados.join(', '),
                observacoes_itens: formData.get('observacao_itens'),
                data_coleta: formData.get('data_coleta'),
                periodo_preferencia: formData.get('periodo_preferencia'),
                distancia_estimada: distancia,
            };

            let agendamentoID = null;

            fetch('/agendamento-coleta', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(dadosEnvioBD)
            })
            .then(response => {
                if (!response.ok) throw new Error('Falha ao salvar agendamento no BD.');
                return response.json();
            })
            .then(data => {
                agendamentoID = data.agendamento_id;
                sessionStorage.setItem('agendamento_id', agendamentoID);

                return fetch('/salvar-dados-pagamento', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        valor: valorColeta,
                        agendamento_id: agendamentoID
                    })
                });
            })
            .then(response => {
                if (!response.ok) throw new Error('Falha ao salvar valor na sessão.');
                alert("✅ Agendamento salvo! Prosseguindo para o pagamento.");
                window.location.href = "{{ route('pagamento') }}"; // rota corrigida
            })

            .catch(error => {
                console.error('Falha no Processo:', error);
                alert(error.message || 'Ocorreu um erro desconhecido.');
            });
        }

        // --- Ponto de Coleta ---
        const pontoColetaModal = `
            <button class="close-btn" onclick="fecharModal()">×</button>
            <div class="form-header">
                <h3>Qual item você está descartando?</h3>
                <p>Escolha o tipo de material para confirmar sua contribuição.</p>
            </div>
            <div class="item-buttons">
                <button onclick="finalizarPonto('Hardware')">Hardware</button>
                <button onclick="finalizarPonto('Eletrodomésticos')">Eletrodomésticos</button>
                <button onclick="finalizarPonto('Monitores')">Monitores</button>
                <button onclick="finalizarPonto('Computador')">Computador</button>
                <button onclick="finalizarPonto('Pilhas')">Pilhas</button>
            </div>
        `;

        function finalizarPonto(item) {
            const content = `
                <button class="close-btn" onclick="fecharModal()">×</button>
                <div class="success-message">
                    <p class="icon-success">♻️</p>
                    <h2>Descarte de ${item} realizado!</h2>
                    <p>Você contribuiu para um planeta mais limpo 🌎<br>Obrigado pela sua atitude sustentável!</p>
                    <button class="action-button" onclick="fecharModal()">Continuar</button>
                </div>
            `;
            document.getElementById("modalContent").innerHTML = content;
        }
        function preencherCamposUsuario() {
    const nomeInput = document.querySelector('input[name="nome_completo"]');
    const emailInput = document.querySelector('input[name="email"]');

    @auth
        nomeInput.value = "{{ Auth::user()->name }}";
        emailInput.value = "{{ Auth::user()->email }}";
    @endauth

    alert("Dados preenchidos com sucesso!");
}
    </script>

</body>
</html>
