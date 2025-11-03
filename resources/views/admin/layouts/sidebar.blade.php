<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">E.Descarte</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">Eletro</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Painel de Controle</li>

            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fire"></i>
                    <span>Tela Inicial</span>
                </a>
            </li>

            <li class="menu-header">Gerenciamento</li>

            <!-- Menu de Suporte -->
            <li class="{{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.support.index') }}">
                    <i class="fas fa-headset"></i>
                    <span>Chamados de Suporte</span>
                    @php
                        $openTickets = \App\Models\SupportTicket::where('status', 'aberto')->count();
                    @endphp
                    @if($openTickets > 0)
                        <span class="badge badge-danger">{{ $openTickets }}</span>
                    @endif
                </a>
            </li>

            <li class="menu-header">Produtos</li>

               <!-- Menu de Suporte -->
            <li class="{{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.products.index') }}">
                    <i class="fas fa-headset"></i>
                    <span>Criar produtos</span>
                    @php
                        $openTickets = \App\Models\SupportTicket::where('status', 'aberto')->count();
                    @endphp
                    @if($openTickets > 0)
                        <span class="badge badge-danger">{{ $openTickets }}</span>
                    @endif
                </a>
            </li>
 <li class="menu-header">Sair da Area Admin</li>
            <li>
                <a class="nav-link" href="{{ route('tasks.logado') }}">
                    <i class="far fa-square"></i>
                    <span>Ir para o Site</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
