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

      <!-- DESCARTES REALIZADOS -->
      <article class="accordion" id="descartes">
        <button class="acc-btn" aria-expanded="false" aria-controls="descartes-panel">
          <span>♻️ Descartes Realizados</span>
          <svg class="acc-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7 10l5 5 5-7"/></svg>
        </button>

        <div id="descartes-panel" class="acc-panel" hidden>
          @if($agendamentos->isEmpty())
            <p class="note">Você ainda não realizou nenhum descarte.</p>
            <a href="{{ route('agendamento.create') }}" class="btn-primary" style="display: inline-block; margin-top: 10px;">
              Agendar Coleta
            </a>
          @else
            <ul class="list">
              @foreach($agendamentos as $agendamento)
                <li class="list-item">
                  <div class="item-left">
                    <strong>Descarte #{{ $agendamento->id }}</strong>
                    <small>{{ $agendamento->data_coleta ? \Carbon\Carbon::parse($agendamento->data_coleta)->format('d/m/Y') : 'Data não definida' }} • {{ $agendamento->periodo_preferencia ?? 'Período não definido' }}</small>
                    @if($agendamento->pagamento && $agendamento->pagamento->points_awarded > 0)
                      <small class="points-badge">
                        ⭐ +{{ number_format($agendamento->pagamento->points_awarded, 0, ',', '.') }} pontos ganhos
                      </small>
                    @endif
                  </div>
                  <div class="item-right">
                    <span class="status {{ $agendamento->status === 'concluido' ? 'done' : ($agendamento->status === 'em_andamento' ? 'inprogress' : 'pending') }}">
                      {{ ucfirst(str_replace('_', ' ', $agendamento->status)) }}
                    </span>
                    <button class="small" onclick="verDescarte({{ $agendamento->id }})">Ver detalhes</button>
                  </div>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      </article>

      <!-- RESGATES DE PRODUTOS -->
      <article class="accordion" id="resgates">
        <button class="acc-btn" aria-expanded="false" aria-controls="resgates-panel">
          <span>🎁 Resgates de Produtos</span>
          <svg class="acc-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7 10l5 5 5-7"/></svg>
        </button>

        <div id="resgates-panel" class="acc-panel" hidden>
          @if($redemptions->isEmpty())
            <p class="note">Você ainda não resgatou nenhum produto.</p>
            <a href="{{ route('products.index') }}" class="btn-primary" style="display: inline-block; margin-top: 10px;">
              Ver Produtos Disponíveis
            </a>
          @else
            <div class="alert alert-warning" style="margin-bottom: 20px;">
              <strong>📸 IMPORTANTE:</strong> Tire um print dos seus resgates e faça a solicitação pelo Suporte para receber seus produtos.
            </div>
            <ul class="list">
              @foreach($redemptions as $redemption)
                <li class="list-item">
                  <div class="item-left">
                    <strong>{{ $redemption->product_name }}</strong>
                    <small>Resgate #{{ $redemption->id }} • {{ $redemption->created_at->format('d/m/Y H:i') }}</small>
                    <small class="points-badge">{{ number_format($redemption->points_spent, 0, ',', '.') }} pontos</small>
                  </div>
                  <div class="item-right">
                    <span class="status {{ $redemption->status_class }}">
                      {{ $redemption->status_label }}
                    </span>
                    <button class="small" onclick="verResgate({{ $redemption->id }})">Ver detalhes</button>
                  </div>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      </article>

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

      <!-- EM ANDAMENTO -->
      <article class="accordion" id="andamento">
        <button class="acc-btn" aria-expanded="false" aria-controls="andamento-panel">
          <span>⏳ Em andamento</span>
          <svg class="acc-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7 10l5 5 5-7"/></svg>
        </button>

        <div id="andamento-panel" class="acc-panel" hidden>
          @if($agendamentosAndamento->isEmpty())
            <p class="note">Não há descartes em andamento no momento.</p>
          @else
            <ul class="list">
              @foreach($agendamentosAndamento as $agendamento)
                <li class="list-item">
                  <div class="item-left">
                    <strong>Descarte #{{ $agendamento->id }}</strong>
                    <small>Coleta agendada: {{ \Carbon\Carbon::parse($agendamento->data_coleta)->format('d/m/Y') }} • {{ $agendamento->periodo_preferencia ?? 'Período não definido' }}</small>
                  </div>
                  <div class="item-right">
                    <span class="status pending">{{ ucfirst(str_replace('_', ' ', $agendamento->status)) }}</span>
                    <button class="small" onclick="verDescarte({{ $agendamento->id }})">Ver detalhes</button>
                  </div>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      </article>

      <!-- NOTIFICAÇÕES -->
      <article class="accordion" id="notificacoes">
        <button class="acc-btn" aria-expanded="false" aria-controls="notificacoes-panel">
          <span>🔔 Notificações</span>
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
          <span>📄 Retirar nota Fiscal</span>
          <svg class="acc-icon" viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M7 10l5 5 5-7"/></svg>
        </button>

        <div id="notafiscal-panel" class="acc-panel" hidden>
          <p class="note">Aqui você pode baixar as notas fiscais dos seus descarte concluídos ou solicitar emissão.</p>

          @if($agendamentosConcluidos->isEmpty())
            <p class="note">Nenhuma nota fiscal disponível.</p>
          @else
            <ul class="invoice-list">
              @foreach($agendamentosConcluidos as $agendamento)
                <li>
                  <div>
                    <strong>Nota #{{ $agendamento->id }}</strong>
                    <small>Descarte #{{ $agendamento->id }} — {{ \Carbon\Carbon::parse($agendamento->data_coleta)->format('d/m/Y') }}</small>
                  </div>
                  <div>
                    <button class="small" onclick="baixarNota('{{ $agendamento->id }}')">Baixar PDF</button>
                    <button class="small" onclick="solicitarNota('{{ $agendamento->id }}')">Solicitar reemissão</button>
                  </div>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      </article>

    </section>
  </main>

  <button class="fab" title="Início" onclick="location.href='{{ route('logado') }}'">🏠</button>

  <!-- MODAL DETALHES -->
  <div id="detailModal" class="detail-modal" aria-hidden="true">
    <div class="detail-body">
      <button class="close-detail" onclick="closeDetail()">×</button>
      <h3 id="detailTitle">Detalhes</h3>
      <div id="detailContent"></div>
    </div>
  </div>

  <script>
    const ticketsData = @json($tickets);
    const redemptionsData = @json($redemptions);
    const agendamentosData = @json($agendamentos);

    // Accordion
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

    // Ver Descarte
    function verDescarte(id) {
      const agendamento = agendamentosData.find(a => a.id === id);
      if (!agendamento) return;

      let statusIcon = '';
      switch(agendamento.status) {
        case 'pendente': statusIcon = '⏳'; break;
        case 'confirmado': statusIcon = '✅'; break;
        case 'em_andamento': statusIcon = '🔄'; break;
        case 'concluido': statusIcon = '✅'; break;
        case 'cancelado': statusIcon = '❌'; break;
        default: statusIcon = '📋';
      }

      let content = `
        <div class="ticket-details">
          <p><strong>ID do Descarte:</strong> #${agendamento.id}</p>
          <p><strong>Nome:</strong> ${agendamento.nome_completo || 'N/A'}</p>
          <p><strong>Telefone:</strong> ${agendamento.telefone || 'N/A'}</p>
          <p><strong>Email:</strong> ${agendamento.email || 'N/A'}</p>
          <hr>
          <p><strong>Itens Descartados:</strong> ${agendamento.itens_descartados || 'N/A'}</p>
          <p><strong>Data da Coleta:</strong> ${agendamento.data_coleta ? new Date(agendamento.data_coleta).toLocaleDateString('pt-BR') : 'Não definida'}</p>
          <p><strong>Período de Preferência:</strong> ${agendamento.periodo_preferencia || 'N/A'}</p>
          <p><strong>Distância Estimada:</strong> ${agendamento.distancia_estimada || 'N/A'} km</p>
          <p><strong>Status:</strong> ${statusIcon} ${agendamento.status.replace('_', ' ').toUpperCase()}</p>
          <hr>
      `;

      if (agendamento.observacoes_itens) {
        content += `<p><strong>Observações:</strong> ${agendamento.observacoes_itens}</p><hr>`;
      }

      if (agendamento.pagamento) {
        content += `
          <div style="background: rgba(0,255,136,0.1); padding: 15px; border-radius: 8px; border: 1px solid #00ff88;">
            <p><strong>💰 Informações de Pagamento:</strong></p>
            <p><strong>Valor:</strong> R$ ${parseFloat(agendamento.pagamento.valor).toFixed(2).replace('.', ',')}</p>
            <p><strong>Método:</strong> ${agendamento.pagamento.metodo.toUpperCase()}</p>
            <p><strong>Status do Pagamento:</strong> ${agendamento.pagamento.status.toUpperCase()}</p>
        `;
        
        if (agendamento.pagamento.points_awarded > 0) {
          content += `
            <p><strong>⭐ Descarte Points Ganhos:</strong> <span style="color: #00ff88; font-weight: bold; font-size: 1.2em;">${agendamento.pagamento.points_awarded.toLocaleString('pt-BR')}</span></p>
          `;
        }
        
        content += `</div><hr>`;
      }

      content += `
          <p><strong>Criado em:</strong> ${new Date(agendamento.created_at).toLocaleString('pt-BR')}</p>
        </div>
      `;

      document.getElementById('detailTitle').innerText = `Descarte #${agendamento.id}`;
      document.getElementById('detailContent').innerHTML = content;
      document.getElementById('detailModal').style.display = 'flex';
      document.getElementById('detailModal').setAttribute('aria-hidden', 'false');
    }

    // Ver Resgate
    function verResgate(id) {
      const redemption = redemptionsData.find(r => r.id === id);
      if (!redemption) return;

      let statusIcon = '';
      switch(redemption.status) {
        case 'pending': statusIcon = '⏳'; break;
        case 'processing': statusIcon = '🔄'; break;
        case 'completed': statusIcon = '✅'; break;
        case 'cancelled': statusIcon = '❌'; break;
      }

      let content = `
        <div class="ticket-details">
          <div style="text-align: center; margin-bottom: 20px;">
            ${redemption.product_image ? `<img src="${redemption.product_image}" alt="${redemption.product_name}" style="max-width: 200px; border-radius: 8px; border: 2px solid #00ff88;">` : ''}
          </div>
          <p><strong>Produto:</strong> ${redemption.product_name}</p>
          <p><strong>Descrição:</strong> ${redemption.product_description || 'N/A'}</p>
          <p><strong>Pontos gastos:</strong> <span style="color: #00ff88; font-weight: bold;">${redemption.points_spent.toLocaleString('pt-BR')}</span></p>
          <p><strong>Status:</strong> ${statusIcon} ${redemption.status_label}</p>
          <p><strong>Data do resgate:</strong> ${new Date(redemption.created_at).toLocaleString('pt-BR')}</p>
          <hr>
          <div class="alert alert-warning">
            <strong>📸 IMPORTANTE:</strong><br>
            Tire um print desta tela e faça a solicitação pelo <strong>Suporte</strong> informando o ID do resgate: <strong>#${redemption.id}</strong>
          </div>
      `;

      if (redemption.admin_notes) {
        content += `
          <hr>
          <div class="admin-response">
            <p><strong>📝 Observações do Admin:</strong></p>
            <p>${redemption.admin_notes}</p>
          </div>
        `;
      }

      if (redemption.status === 'pending') {
        content += `<p class="note"><em>Aguardando processamento...</em></p>`;
      }

      content += `</div>`;

      document.getElementById('detailTitle').innerText = `Resgate #${redemption.id}`;
      document.getElementById('detailContent').innerHTML = content;
      document.getElementById('detailModal').style.display = 'flex';
      document.getElementById('detailModal').setAttribute('aria-hidden', 'false');
    }

    // Ver Chamado
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
      alert('Simulação: iniciando download da nota do descarte #' + id);
    }

    function solicitarNota(id) {
      alert('Solicitação de reemissão enviada para o descarte #' + id);
    }

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeDetail();
    });
  </script>

</body>
</html>