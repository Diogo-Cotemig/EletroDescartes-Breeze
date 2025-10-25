<!DOCTYPE html>
<html lang="pt-BR">
<head>
  @vite(['resources/css/Style.css', 'resources/js/Script.js', 'resources/js/server.js'])
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Registrar-se — Eletro Descartes</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap-social/bootstrap-social.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-6 offset-xl-3">

            <div class="login-brand">
              <img src="{{ asset('backend/assets/img/LOGO.png') }}" alt="logo" width="100" style="width: 80%; height:auto; box-shadow:none;">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Registrar-se</h4></div>

              <div class="card-body">
                <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate="">
                  @csrf
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="name">Nome</label>
                      <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                      @error('name')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="lastname">Sobrenome</label>
                      <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @error('email')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password">Senha</label>
                      <input id="password" type="password" class="form-control" name="password" required>
                      @error('password')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="password_confirmation">Confirmar senha</label>
                      <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="terms" class="custom-control-input" id="terms" required>
                      <label class="custom-control-label" for="terms">Concordo com os termos e condições</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Criar conta
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <div class="mt-5 text-muted text-center">
              Já tem uma conta? <a href="{{ route('login') }}">Fazer login</a>
            </div>
            <div class="simple-footer">
              Criado por Eletro Descartes &copy; 2025
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('backend/assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/popper.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/stisla.js') }}"></script>
  <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
  <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
</body>
</html>
