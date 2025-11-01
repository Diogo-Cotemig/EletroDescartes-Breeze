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
                 @if(Auth::user()->role != 'admin')
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    Meu Perfil
                </a>
                @endif
                {{-- Exibir botão "Logar como Admin" apenas se o usuário for admin --}}
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 4a1 1 0 011-1h4l1 2h6l1-2h4a1 1 0 011 1v2H3V4z" />
                            <path fill-rule="evenodd" d="M3 8h18v12a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm9 3a1 1 0 00-1 1v5h2v-5a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Logar como Admin
                    </a>
                @endif

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
