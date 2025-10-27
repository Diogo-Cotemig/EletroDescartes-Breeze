<nav>
 @vite("resources/css/cards.css")
        <!-- Dropdown do Usuário -->
        <li class="user-dropdown" x-data="{ open: false }">
            <button @click="open = !open" class="user-button">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <svg class="dropdown-arrow" :class="{'rotate': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <div x-show="open"
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="dropdown-menu"
                 style="display: none;">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    Meu Perfil
                </a>

                <form method="GET" action="{{ route('historico') }}" class="dropdown-form">
                    <button type="submit" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon" viewBox="0 0 576 512"  fill="currentColor"><path d="M160 169.3c28.3-12.3 48-40.5 48-73.3 0-44.2-35.8-80-80-80S48 51.8 48 96c0 32.8 19.7 61 48 73.3l0 54.7-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l224 0 0 54.7c-28.3 12.3-48 40.5-48 73.3 0 44.2 35.8 80 80 80s80-35.8 80-80c0-32.8-19.7-61-48-73.3l0-54.7 224 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0 0-54.7c28.3-12.3 48-40.5 48-73.3 0-44.2-35.8-80-80-80s-80 35.8-80 80c0 32.8 19.7 61 48 73.3l0 54.7-256 0 0-54.7z"/>
                        </svg>
                   Histórico
                </button>
                </form>
                <form method="POST" action="{{ route('logout') }}" class="dropdown-form">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                        </svg>
                        Sair
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>

<style>
/* Estilos para o dropdown do usuário */
.user-dropdown {
    position: relative;
}

.user-button {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(0, 170, 255, 0.1);
    border: 1px solid rgba(0, 170, 255, 0.3);
    padding: 8px 16px;
    border-radius: 25px;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    font-weight: 500;
}

.user-button:hover {
    background: rgba(0, 170, 255, 0.2);
    border-color: #0af;
    transform: translateY(-2px);
}

.user-name {
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.dropdown-arrow {
    width: 16px;
    height: 16px;
    transition: transform 0.3s ease;
}

.dropdown-arrow.rotate {
    transform: rotate(180deg);
}

.dropdown-menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    min-width: 200px;
    background: rgba(26, 26, 26, 0.98);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 170, 255, 0.2);
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    z-index: 1000;
    overflow: hidden;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 12px 20px;
    background: none;
    border: none;
    color: #ccc;
    text-decoration: none;
    text-align: left;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.dropdown-item:hover {
    background: rgba(0, 170, 255, 0.1);
    color: #0af;
}

.dropdown-icon {
    width: 18px;
    height: 18px;
}

.dropdown-form {
    margin: 0;
    padding: 0;
}

/* Ajuste para remover estilos padrão do botão */
.dropdown-item[type="submit"] {
    font-family: inherit;
}

/* Responsivo - Menu Mobile */

/* Ajuste para o dropdown no menu mobile */
</style>

<script>
// Script para o menu hamburger (se ainda não tiver)
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.querySelector('.navbar ul');

    if (hamburger) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }

    // Fechar dropdown ao clicar fora (fallback caso Alpine.js não esteja carregado)
    document.addEventListener('click', function(event) {
        const userDropdown = document.querySelector('.user-dropdown');
        if (userDropdown && !userDropdown.contains(event.target)) {
            const dropdownMenu = userDropdown.querySelector('.dropdown-menu');
            if (dropdownMenu) {
                dropdownMenu.style.display = 'none';
            }
        }
    });
});
</script>
