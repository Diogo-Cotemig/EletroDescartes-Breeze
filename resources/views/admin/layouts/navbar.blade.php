<nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
@if (Auth::user()->image != null)
    <img src="{{ asset(Auth::user()->image) }}" class="rounded-circle mr-1" width="30" height="30" style="object-fit: cover;">
@else
    <img src="{{ asset('uploads/padrao.png') }}" class="rounded-circle mr-1" width="30" height="30" style="object-fit: cover;">
@endif

            <div class="d-sm-none d-lg-inline-block">Ola, {{ Auth::user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
                    <!-- Edição de rota de Perfil, Diogo (29/10) -->
              <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Perfil
              </a>
              <form method="post" action="{{ route('logout') }}">
                @csrf
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Sair da Conta
              </a>
               </form>
            </div>
          </li>
        </ul>
      </nav>
