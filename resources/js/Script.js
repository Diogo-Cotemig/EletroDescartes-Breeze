// Unifique todo o seu código JavaScript em um único listener para 'DOMContentLoaded'
document.addEventListener('DOMContentLoaded', function() {
    
        // Encontra o botão e o contêiner do texto
        const showButton = document.getElementById('show-text-button');
        const textContainer = document.getElementById('mission-text-container');
        
        // Adiciona um "ouvinte de evento" para o clique no botão
        showButton.addEventListener('click', function(event) {
            // Previne o comportamento padrão do link (ir para o topo da página)
            event.preventDefault();

            // Alterna a visibilidade do contêiner de texto
            textContainer.classList.toggle('visible-content');
            
            // Opcional: Altera o texto do botão
            if (textContainer.classList.contains('visible-content')) {
                showButton.textContent = 'Ocultar Texto';
            } else {
                showButton.textContent = 'Conheça a EletroDescarte';
            }
        });
    // ----------------------
    // Botão "Saiba Mais"
    // ----------------------
    const btnSaibaMais = document.getElementById("btn");
    const textoDestino = document.getElementById('texto');

    if (btnSaibaMais && textoDestino) {
        btnSaibaMais.addEventListener('click', function(event) {
            event.preventDefault();
            textoDestino.scrollIntoView({ behavior: 'smooth' });
        });
    }

    // ----------------------
    // Modais de Login/Cadastro/Recuperação
    // ----------------------
    const loginModal = document.getElementById("loginModal");
    const registerModal = document.getElementById("registerModal");
    const forgotModal = document.getElementById("forgotModal");

    // Funções unificadas
    window.openModal = function() {
        loginModal.style.display = "flex";
        document.body.classList.add('no-scroll');
        registerModal.style.display = 'none';
        forgotModal.style.display = 'none';
    }

    window.closeModal = function() {
        loginModal.style.display = "none";
        document.body.classList.remove('no-scroll');
    }

    window.openRegisterModal = function() {
        registerModal.style.display = 'flex';
        document.body.classList.add('no-scroll');
        loginModal.style.display = 'none';
        forgotModal.style.display = 'none';
    }

    window.closeRegisterModal = function() {
        registerModal.style.display = 'none';
        document.body.classList.remove('no-scroll');
    }

    window.openForgotModal = function() {
        forgotModal.style.display = 'flex';
        document.body.classList.add('no-scroll');
        loginModal.style.display = 'none';
        registerModal.style.display = 'none';
    }

    window.closeForgotModal = function() {
        forgotModal.style.display = 'none';
        document.body.classList.remove('no-scroll');
    }

    // Fechar ao clicar fora
    window.onclick = function(e) {
        if (e.target === loginModal) {
            closeModal();
        } else if (e.target === registerModal) {
            closeRegisterModal();
        } else if (e.target === forgotModal) {
            closeForgotModal();
        }
    };
    
    // ----------------------
    // Modal "Quem nós somos"
    // ----------------------
    const myModal = document.getElementById('myModal');
    const openModalBtn = document.getElementById('openModal');
    const closeModalBtn = document.getElementById('closeModal');
    
    // O seu HTML tem dois elementos com o mesmo ID "closeModal",
    // o que causa conflito. Mude um deles ou use querySelectorAll
    // Para resolver agora, vamos usar um listener no pai.
    
    if (openModalBtn && closeModalBtn) {
        openModalBtn.addEventListener('click', function() {
            document.body.classList.add('no-scroll');
            myModal.style.display = 'block';
        });

        closeModalBtn.addEventListener('click', function() {
            document.body.classList.remove('no-scroll');
            myModal.style.display = 'none';
        });
    }

    // ----------------------
    // Leia Mais
    // ----------------------
    const fullText = `A Eletro-Descarte tem como missão fornecer uma solução eficiente e responsável para o descarte de produtos eletrônicos que, muitas vezes, acabam sendo descartados de forma inadequada, causando poluição e desperdício de recursos valiosos. A empresa oferece um serviço completo de coleta e reciclagem de equipamentos como computadores, celulares e outros aparelhos eletrônicos.
A empresa também tem um compromisso com a educação e a conscientização. A Eletro-Descarte desenvolve programas de sensibilização para consumidores e empresas, mostrando a importância do descarte correto e os benefícios da reciclagem de lixo eletrônico. Além disso, oferece soluções práticas para empresas que desejam adotar práticas sustentáveis em seus processos, com serviços personalizados de coleta e gestão de resíduos eletrônicos.`;

    const previewText = fullText.substring(0, 100);
    const remainingText = fullText.substring(100);

    const previewSpan = document.getElementById("preview-text");
    const moreSpan = document.getElementById("more-text");
    const toggleBtn = document.getElementById("toggle-text");
    
    if (previewSpan && moreSpan && toggleBtn) {
        previewSpan.textContent = previewText;

        let expanded = false;

        function animateText(text, element, callback) {
            let index = 0;
            element.textContent = "";

            const interval = setInterval(() => {
                element.textContent += text.charAt(index);
                index++;
                if (index === text.length) {
                    clearInterval(interval);
                    if (callback) callback();
                }
            }, 5);
        }

        toggleBtn.addEventListener("click", function (e) {
            e.preventDefault();
            if (!expanded) {
                animateText(remainingText, moreSpan);
                toggleBtn.textContent = "Mostrar menos";
            } else {
                moreSpan.textContent = "";
                toggleBtn.textContent = "Leia mais";
            }
            expanded = !expanded;
        });
    }

    // ----------------------
    // Funções isoladas
    // ----------------------
    window.mudarFavicon = function() {
        const favicon = document.getElementById("favicon");
        favicon.href = "favicon2.ico";
    }

    window.openGoogleMaps = function() {
        window.open("http://googleusercontent.com/maps.google.com/4", "_blank");
    }

    // Outras funções que você pode precisar
    // Adicione-as aqui e use window. para que sejam acessíveis
});

