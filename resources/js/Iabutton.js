
document.addEventListener("DOMContentLoaded", () => {
  // Obtém elementos
  const chat = document.getElementById('chatbot');
  const chatBtn = document.getElementById('chatbot-btn');
  const closeBtn = document.getElementById('close-chat');
  const chatBody = document.getElementById('chat-body');
  const userInput = document.getElementById('user-input');
  const sendBtn = document.getElementById('send-btn');

  // Debug inicial — abra o console e confira estas mensagens
  console.log("[Ecolly] inicializando chat...");
  console.log("[Ecolly] elementos:", { chat, chatBtn, closeBtn, chatBody, userInput, sendBtn });

  // Se algum elemento crítico estiver faltando, informa no console
  if (!chat || !chatBtn || !closeBtn || !chatBody || !userInput) {
    console.error("[Ecolly] ERRO: algum elemento do chat está faltando. Verifique os IDs: chatbot, chatbot-btn, close-chat, chat-body, user-input");
    // não retorna para tentar aplicar fallback para sendBtn só
  }

  // Funções básicas
  function abrirChat() {
    chat.classList.add('show');
    chat.setAttribute('aria-hidden', 'false');
    chatBtn.style.display = 'none';
    console.log("[Ecolly] chat aberto");
    userInput.focus();
  }
  function fecharChat() {
    chat.classList.remove('show');
    chat.setAttribute('aria-hidden', 'true');
    chatBtn.style.display = 'flex';
    console.log("[Ecolly] chat fechado");
  }

  // Adiciona listeners (com checagens)
  if (chatBtn) {
    chatBtn.addEventListener('click', (e) => {
      e.preventDefault();
      abrirChat();
    });
  } else {
    console.warn("[Ecolly] chatBtn não encontrado — botão flutuante não funcionará.");
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', (e) => {
      e.preventDefault();
      fecharChat();
    });
  }

  // Base de respostas (mantida conforme você pediu — exemplo reduzido aqui para teste)
   const respostas = [
    {
      keywords: ["historico", "notificacoes", "acompanhar", "pontos", "esta", "onde", "ponto", "como"],
      respostaFunc: () => {
        const wrapper = document.createElement("div");
        wrapper.innerHTML = "Temos pontos de coleta em várias regiões de BH. Caso esteja interessado, visite o botão abaixo:";

        const btn = document.createElement("button");
        btn.textContent = "Ir para Pontos de Coleta";
        btn.classList.add("goto-descartar");
        btn.addEventListener("click", () => {
          window.location.href = "/descartar"; // ou use '{{ route("descartar") }}' se injetado via Blade
        });

        wrapper.appendChild(document.createElement("br"));
        wrapper.appendChild(btn);
        return wrapper;
      }
    },
    { keywords: ["ola", "como vai", "blz", "tudo joia"],
      resposta: "Olá, tudo joia? Sou a assistente virtual da Eletro Descarte e estou aqui para te ajudar 😊" },
    { keywords: ["horario", "funcionamento", "abrem", "fecham", "hora"],
      resposta: "Nosso horário de atendimento é de segunda a sexta, das 8h às 18h. 😊" },
    { keywords: ["descartar", "lixo", "itens", "eletrônico", "equipamentos", "materiais"],
      resposta: "Aceitamos computadores, celulares, cabos, pilhas, monitores, impressoras e muito mais! ♻️" },
    { keywords: ["coleta", "buscar", "retirada", "pegar", "agendar", "buscar em casa"],
      resposta: "Sim! Fazemos coleta domiciliar agendada." },
    { keywords: ["certificado", "comprovante", "declaração"],
      resposta: "Emitimos certificado de descarte ambientalmente correto para empresas e pessoas físicas. ✅" },
    { keywords: ["contato", "telefone", "email", "falar com", "atendente","numero"],
      resposta: "Você pode falar com nossa equipe pelo telefone (31) 99799-8261 ou e-mail EletroDescarteBH@gmail.com.br ☎️" },
    { keywords: ["empresa", "quem são", "sobre", "história", "quem é você"],
      resposta: "Somos uma empresa especializada em reciclagem de lixo eletrônico, promovendo sustentabilidade e tecnologia verde. 🌍" },
    { keywords: ["obrigado", "valeu", "agradecido"],
      resposta: "De nada! 😄 É sempre um prazer ajudar." }
  ];

  function similaridade(a, b) {
    a = (a || "").toLowerCase();
    b = (b || "").toLowerCase();
    const aPalavras = a.split(" ").filter(Boolean);
    const bPalavras = b.split(" ").filter(Boolean);
    if (aPalavras.length === 0) return 0;
    let acertos = 0;
    aPalavras.forEach(pA => {
      bPalavras.forEach(pB => {
        if (pB.includes(pA.slice(0, 4))) acertos++;
      });
    });
    return acertos / aPalavras.length;
  }

  function getResposta(msg) {
    if (!msg) return "Por favor, digite algo.";
    let melhorScore = 0;
    let melhorResposta = "Desculpe 😅, não entendi bem. Pode reformular sua pergunta?";
    let melhorFunc = null;

    for (const r of respostas) {
      let score = 0;
      for (const k of r.keywords) score += similaridade(msg, k);
      if (score > melhorScore) {
        melhorScore = score;
        melhorResposta = r.resposta || null;
        melhorFunc = r.respostaFunc || null;
      }
    }

    return melhorFunc || melhorResposta;
  }

  function addMessage(resposta, sender) {
    const div = document.createElement("div");
    div.classList.add(sender === "user" ? "user" : "bot");
    if (typeof resposta === "function") {
      const el = resposta();
      div.appendChild(el);
    } else {
      div.innerHTML = resposta;
    }
    chatBody.appendChild(div);
    chatBody.scrollTop = chatBody.scrollHeight;
  }

  function sendMessage() {
    // Segurança: previne execução se input não existir
    if (!userInput) {
      console.error("[Ecolly] userInput não encontrado; não é possível enviar mensagem.");
      return;
    }

    const msg = userInput.value.trim();
    if (!msg) {
      console.log("[Ecolly] mensagem vazia — nada a enviar.");
      return;
    }

    addMessage(msg, "user");
    userInput.value = "";
    userInput.focus();

    setTimeout(() => {
      const resposta = getResposta(msg);
      addMessage(resposta, "bot");
    }, 400);
  }

  // === Problema provável: sendBtn null ou interceptado ===
  if (sendBtn) {
    // Remove qualquer onclick inline que possa causar duplicidade
    try { sendBtn.removeAttribute('onclick'); } catch (err) { /* ignore */ }

    // Garantir que o botão não esteja desabilitado
    sendBtn.disabled = false;

    sendBtn.addEventListener('click', (e) => {
      e.preventDefault();
      console.log("[Ecolly] sendBtn clicado (listener direto).");
      sendMessage();
    });
  } else {
    console.warn("[Ecolly] sendBtn não encontrado. Tentando fallback por delegação no container...");
  }

  // Fallback: event delegation no container (captura cliques em qualquer botão com classe send-btn)
  document.body.addEventListener('click', function(e) {
    const target = e.target;
    if (!target) return;
    // aceita botão com id ou botão com classe
    if (target.id === 'send-btn' || target.closest && target.closest('#chatbot') && target.classList.contains('send-btn')) {
      e.preventDefault();
      console.log("[Ecolly] clique detectado por delegação.");
      sendMessage();
    }
  });

  // Enter -> enviar
  if (userInput) {
    userInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        sendMessage();
      }
    });
  }

  // DEBUG visual: exibe se o botão está coberto por outro elemento
  function checarCobertura(element) {
    if (!element) return;
    const rect = element.getBoundingClientRect();
    const x = rect.left + rect.width/2;
    const y = rect.top + rect.height/2;
    const topEl = document.elementFromPoint(x, y);
    if (topEl && topEl !== element && !element.contains(topEl)) {
      console.warn("[Ecolly] Elemento possivelmente coberto por:", topEl, "na posição", {x,y});
    } else {
      console.log("[Ecolly] Elemento não coberto na posição central.");
    }
  }
  // checa cobertura do sendBtn e do chatbot-btn
  setTimeout(() => {
    checarCobertura(sendBtn);
    checarCobertura(chatBtn);
  }, 500);

});
