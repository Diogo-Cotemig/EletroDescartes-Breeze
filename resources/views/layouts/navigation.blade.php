<nav>

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
                  <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon" viewBox="0 0 640 640"><path d="M128 96C92.7 96 64 124.7 64 160L64 480C64 515.3 92.7 544 128 544C128 561.7 142.3 576 160 576C177.7 576 192 561.7 192 544L448 544C448 561.7 462.3 576 480 576C497.7 576 512 561.7 512 544C547.3 544 576 515.3 576 480L576 160C576 124.7 547.3 96 512 96L128 96zM320 320C320 284.7 291.3 256 256 256C220.7 256 192 284.7 192 320C192 355.3 220.7 384 256 384C291.3 384 320 355.3 320 320zM128 320C128 249.3 185.3 192 256 192C326.7 192 384 249.3 384 320C384 390.7 326.7 448 256 448C185.3 448 128 390.7 128 320zM512 272C512 289.8 502.3 305.3 488 313.6L488 392C488 405.3 477.3 416 464 416C450.7 416 440 405.3 440 392L440 313.6C425.7 305.3 416 289.8 416 272C416 245.5 437.5 224 464 224C490.5 224 512 245.5 512 272z"/>
                </svg> Histórico
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
