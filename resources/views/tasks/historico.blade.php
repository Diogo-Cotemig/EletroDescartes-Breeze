<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Histórico e Configurações — EletroDescarte</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700;800&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('img/Eletro-DescarteLOGO.png') }}">
  @vite(['resources/css/historico.css'])
</head>
<body>
  <header class="hd">
    <div class="hd-left">
      <img src="{{ asset('img/Eletro-DescarteLOGO.png') }}" alt="EletroDescarte" class="logo" />
      <h1 class="site-title">Eletro<span>Descarte</span></h1>
    </div>
  </header>

  <main class="main">
    <section class="hero">
      <h2>Histórico e Configurações adicionais</h2>
      <div class="neon-line"></div>
    </section>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <section class="accordion-list">

      <!-- CHAMADOS DE SUPORTE -->
      <article class="accordion" id="chamados">
        <button class="acc-btn" aria-expanded="false" aria-controls="chamados-panel">
          <span>🎫 Chamados de Suporte</span>
          <svg class="acc-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7 10l5 5 5-7"/></svg>
        </button>

        <div id="chamados-panel" class="acc-panel" hidden>
          @if($tickets->isEmpty())
            <p class="note">Você ainda não possui chamados de suporte.</p>
          @else
            <ul class="list">
              @foreach($tickets as $ticket)
                <li class="list-item">
                  <div class="item-left">
                    <strong>Chamado #{{ $ticket->id }}</strong>
                    <small>{{ $ticket->created_at->format('d/m/Y H:i') }} • {{ $ticket->category_label }}</small>
                    <small class="priority-badge">{{ $ticket->priority_label }}</small>
                  </div>
                  <div class="item-right">
                    <span class="status {{ $ticket->status === 'respondido' ? 'done' : ($ticket->status === 'em_andamento' ? 'inprogress' : 'pending') }}">
                      {{ $ticket->status_label }}
                    </span>
                    <button class="small" onclick="verChamado({{ $ticket->id }})">Ver detalhes</button>
                  </div>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      </article>

      <!-- CONCLUÍDAS -->
      <article class="accordion" id="concluidas">
        <button class="acc-btn" aria-expanded="false" aria-controls="concluidas-panel">
          <span>Concluídas</span>
          <svg class="acc-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7 10l5 5 5-7"/></svg>
        </button>

        <div id="concluidas-panel" class="acc-panel" hidden>
          <ul class="list">
            <li class="list-item">
              <div class="item-left">
                <strong>Pedido #1245</strong>
                <small>Entrega: 18/10/2025 • Monitor</small>
              </div>
              <div class="item-right">
                <span class="status done">Concluído</span>
                <button class="small" onclick="verDetalhes('1245')">Detalhes</button>
              </div>
            </li>
          </ul>
        </div>
      </article>

      <!-- EM ANDAMENTO -->
      <article class="accordion" id="andamento">
        <button class="acc-btn" aria-expanded="false" aria-controls="andamento-panel">
          <span>Em andamento</span>
          <svg class="acc-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7 10l5 5 5-7"/></svg>
        </button>

        <div id="andamento-panel" class="acc-panel" hidden>
          <ul class="list">
            <li class="list-item">
              <div class="item-left">
                <strong>Pedido #1278</strong>
                <small>Coleta agendada: 28/10/2025 • Monitores (2)</small>
              </div>
              <div class="item-right">
                <span class="status pending">Aguardando</span>
                <button class="small" onclick="verDetalhes('1278')">Detalhes</button>
              </div>
            </li>
          </ul>
        </div>
      </article>

      <!-- NOTIFICAÇÕES -->
      <article class="accordion" id="notificacoes">
        <button class="acc-btn" aria-expanded="false" aria-controls="notificacoes-panel">
          <span>Notificações</span>
          <svg class="acc-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7 10l5 5 5-7"/></svg>
        </button>

        <div id="notificacoes-panel" class="acc-panel" hidden>
          <div class="notifications-grid">
            <label class="chk">
              <input type="checkbox" id="noti-realtime" />
              <div class="chk-desc">
                <strong>Status em tempo real</strong>
                <small>Receba atualizações sobre o andamento da coleta.</small>
              </div>
            </label>

            <label class="chk">
              <input type="checkbox" id="noti-ofertas" />
              <div class="chk-desc">
                <strong>Ofertas</strong>
                <small>Promoções e descontos em serviços parceiros.</small>
              </div>
            </label>

            <label class="chk">
              <input type="checkbox" id="noti-assistente" />
              <div class="chk-desc">
                <strong>Assistente Virtual</strong>
                <small>Dicas e apoio automatizado por chat.</small>
              </div>
            </label>
          </div>

          <div class="noti-actions">
            <button class="btn-save" id="salvarNotificacoes">Salvar configurações</button>
            <button class="btn-reset" id="resetNotificacoes">Restaurar padrão</button>
          </div>
        </div>
      </article>

      <!-- NOTA FISCAL -->
      <article class="accordion" id="notafiscal">
        <button class="acc-btn" aria-expanded="false" aria-controls="notafiscal-panel">
          <span>Retirar nota Fiscal</span>
          <svg class="acc-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7 10l5 5 5-7"/></svg>
        </button>

        <div id="notafiscal-panel" class="acc-panel" hidden>
          <p class="note">Aqui você pode baixar as notas fiscais dos seus descarte concluídos ou solicitar emissão.</p>

          <ul class="invoice-list">
            <li>
              <div>
                <strong>Nota #1245</strong>
                <small>Pedido #1245 — 18/10/2025</small>
              </div>
              <div>
                <button class="small" onclick="baixarNota('1245')">Baixar PDF</button>
                <button class="small" onclick="solicitarNota('1245')">Solicitar reemissão</button>
              </div>
            </li>
          </ul>
        </div>
      </article>

    </section>
  </main>

  <button class="fab" title="Início" onclick="location.href='{{ route('logado') }}'">🏠</button>

  <!-- MODAL DETALHES CHAMADOS -->
  <div id="detailModal" class="detail-modal" aria-hidden="true">
    <div class="detail-body">
      <button class="close-detail" onclick="closeDetail()">×</button>
      <h3 id="detailTitle">Detalhes</h3>
      <div id="detailContent"></div>
    </div>
  </div>

  <script>
    const ticketsData = @json($tickets);

    document.querySelectorAll('.acc-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', (!expanded).toString());
        const panel = document.getElementById(btn.getAttribute('aria-controls'));
        if (!expanded) {
          panel.hidden = false;
          panel.style.maxHeight = panel.scrollHeight + 'px';
        } else {
          panel.style.maxHeight = '0';
          setTimeout(() => panel.hidden = true, 300);
        }
      });
    });

    document.querySelectorAll('.acc-panel').forEach(p => {
      p.style.maxHeight = '0';
    });

    function verChamado(id) {
      const ticket = ticketsData.find(t => t.id === id);
      if (!ticket) return;

      let content = `
        <div class="ticket-details">
          <p><strong>Categoria:</strong> ${ticket.category_label}</p>
          <p><strong>Prioridade:</strong> ${ticket.priority_label}</p>
          <p><strong>Status:</strong> ${ticket.status_label}</p>
          <p><strong>Data de abertura:</strong> ${new Date(ticket.created_at).toLocaleString('pt-BR')}</p>
          <hr>
          <p><strong>Descrição:</strong></p>
          <p>${ticket.description}</p>
      `;

      if (ticket.admin_response) {
        content += `
          <hr>
          <div class="admin-response">
            <p><strong>✅ Resposta do Suporte:</strong></p>
            <p>${ticket.admin_response}</p>
            <small>Respondido em: ${new Date(ticket.responded_at).toLocaleString('pt-BR')}</small>
          </div>
        `;
      } else {
        content += `<p class="note"><em>Aguardando resposta do suporte...</em></p>`;
      }

      content += `</div>`;

      document.getElementById('detailTitle').innerText = `Chamado #${ticket.id}`;
      document.getElementById('detailContent').innerHTML = content;
      document.getElementById('detailModal').style.display = 'flex';
      document.getElementById('detailModal').setAttribute('aria-hidden', 'false');
    }

    function verDetalhes(id) {
      const titles = {
        '1245': { title: 'Pedido #1245', content: '<p><strong>Itens:</strong> 2 Monitores<br><strong>Endereço:</strong> Av. Amazonas, 2450<br><strong>Status:</strong> Concluído</p>' },
        '1278': { title: 'Pedido #1278', content: '<p><strong>Agendamento:</strong> 28/10/2025<br><strong>Observações:</strong> Cliente solicitou desmontagem.</p>' }
      };
      const r = titles[id] || { title: 'Detalhes', content: '<p>Nenhuma informação disponível.</p>' };
      document.getElementById('detailTitle').innerText = r.title;
      document.getElementById('detailContent').innerHTML = r.content;
      document.getElementById('detailModal').style.display = 'flex';
      document.getElementById('detailModal').setAttribute('aria-hidden', 'false');
    }

    function closeDetail() {
      document.getElementById('detailModal').style.display = 'none';
      document.getElementById('detailModal').setAttribute('aria-hidden', 'true');
    }

    // Notificações
    function loadNotificacoes() {
      const cfg = JSON.parse(localStorage.getItem('cfgNotificacoes') || '{}');
      document.getElementById('noti-realtime').checked = !!cfg.realtime;
      document.getElementById('noti-ofertas').checked = !!cfg.ofertas;
      document.getElementById('noti-assistente').checked = !!cfg.assistente;
    }

    function saveNotificacoes() {
      const cfg = {
        realtime: document.getElementById('noti-realtime').checked,
        ofertas: document.getElementById('noti-ofertas').checked,
        assistente: document.getElementById('noti-assistente').checked
      };
      localStorage.setItem('cfgNotificacoes', JSON.stringify(cfg));
      const btn = document.getElementById('salvarNotificacoes');
      btn.innerText = 'Salvo ✓';
      setTimeout(() => btn.innerText = 'Salvar configurações', 1500);
    }

    function resetNotificacoes() {
      localStorage.removeItem('cfgNotificacoes');
      loadNotificacoes();
      const btn = document.getElementById('resetNotificacoes');
      btn.innerText = 'Restaurado ✓';
      setTimeout(() => btn.innerText = 'Restaurar padrão', 1500);
    }

    document.getElementById('salvarNotificacoes').addEventListener('click', saveNotificacoes);
    document.getElementById('resetNotificacoes').addEventListener('click', resetNotificacoes);
    loadNotificacoes();

    function baixarNota(id) {
      alert('Simulação: iniciando download da nota ' + id);
    }

    function solicitarNota(id) {
      alert('Solicitação de reemissão enviada para nota ' + id);
    }

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeDetail();
    });
  </script>
</body>
</html>
