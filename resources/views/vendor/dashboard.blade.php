<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vendedor - carreteiro</title>
</head>
<body>
<h1>Bem vindo Carreteiro: {{ Auth::user()->name }}</h1>

    <nav>
        <ul>
            <li class="user-dropdown" x-data="{ open: false }">
                <button @click="open = !open" class="user-button">
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="dropdown-arrow" :class="{'rotate': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open"
                     @click.away="open = false"
                     x-transition
                     class="dropdown-menu"
                     style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A1 1 0 015 17V5a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-.121.804L12 21l-6.879-3.196z" />
                        </svg>
                        Meu Perfil
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="dropdown-form">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-9V4" />
                            </svg>
                            Sair
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
