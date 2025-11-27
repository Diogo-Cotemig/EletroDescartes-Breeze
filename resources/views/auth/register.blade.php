<!DOCTYPE html>
<html lang="pt-BR">
<head>
  @vite(['resources/css/Style.css', 'resources/js/Script.js', 'resources/js/server.js'])
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
   <link rel="icon" type="image/png" href="{{ asset('img/Eletro-DescarteLOGO.png') }}">
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

<body style="background: radial-gradient(ellipse 80% 50% at 20% 0%, rgba(0, 255, 136, 0.15) 0%, transparent 50%),
    radial-gradient(ellipse 60% 50% at 80% 100%, rgba(0, 170, 255, 0.1) 0%, transparent 50%),
    linear-gradient(135deg, #000000 0%, #0a0a0a 50%, #111111 100%);">
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
    <input type="checkbox" name="terms" class="custom-control-input" id="terms" disabled required>
    <label class="custom-control-label" for="terms">
      Concordo com os <a href="#" data-toggle="modal" data-target="#modalTermos">termos e condições</a>
    </label>
  </div>
</div>

<!-- MODAL DOS TERMOS DE USO -->
<div class="modal fade" id="modalTermos" tabindex="-1" role="dialog" aria-labelledby="modalTermosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalTermosLabel">Termos de Uso - Eletro-Descarte</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div id="termoTexto" style="height: 350px; overflow-y: auto; padding-right: 10px;">

          <h4>TERMO DE USO DO SISTEMA “Eletro-Descarte”</h4>
          <p>Este Termo de Uso (“Termo”) é um acordo legal entre você, o(a) usuário(a) do sistema, e os desenvolvedores do Projeto “Eletro-Descarte”. Ao utilizar o sistema, você concorda integralmente com este Termo, com a Política de Privacidade e com a LGPD (Lei nº 13.709/2018).</p>

          <h5>CLÁUSULA PRIMEIRA – DAS CONDIÇÕES GERAIS DE USO</h5>
          <p>O sistema “Eletro-Descarte” é destinado à reciclagem e manejo correto de lixo eletrônico.</p>

          <h5>CLÁUSULA SEGUNDA – DA COLETA E USO DE DADOS PESSOAIS</h5>
          <p><b>Dados Pessoais Comuns:</b><br>Nome, CPF, CEP, E-mail</p>
          <p><b>Dados Sensíveis:</b><br>Número do cartão (PAN), Código de segurança (CVV/CVC)</p>

          <h5>CLÁUSULA TERCEIRA – FINALIDADE DA COLETA</h5>
          <p><b>Nome:</b> Identificação do usuário.<br>
             <b>CPF:</b> Emissão de nota fiscal.<br>
             <b>CEP:</b> Localização do serviço.<br>
             <b>E-mail:</b> Comunicação e suporte.<br>
             <b>PAN / CVV:</b> Pagamento e confirmação financeira.</p>

          <h5>CLÁUSULA QUARTA – VEDAÇÕES DO USO</h5>
          <ul>
            <li>Enviar conteúdo ilegal, obsceno ou ofensivo.</li>
            <li>Acessar ou danificar contas de terceiros.</li>
            <li>Violar propriedade intelectual.</li>
          </ul>

          <h5>CLÁUSULA QUINTA – ACEITAÇÃO IMPLÍCITA</h5>
          <p>O uso do sistema implica concordância integral com este Termo.</p>

          <h5>CLÁUSULA SEXTA – DA PROTEÇÃO DOS DADOS</h5>
          <ul>
            <li>Criptografia de arquivos.</li>
            <li>Banco de dados seguro.</li>
            <li>Políticas de segurança e resposta a incidentes.</li>
          </ul>

          <h5>CLÁUSULA SÉTIMA – DO COMPARTILHAMENTO DE DADOS</h5>
          <ul>
            <li>Mediante autorização do titular.</li>
            <li>Obrigação legal ou ordem judicial.</li>
            <li>Assistência técnica quando necessária.</li>
          </ul>

          <h5>CLÁUSULA OITAVA – DIREITOS DO TITULAR</h5>
          <ul>
            <li>Exclusão da conta.</li>
            <li>Revogação do consentimento.</li>
            <li>Solicitar informações sobre seus dados.</li>
          </ul>
          <p>Contato: marcomendes830@gmail.com</p>

          <h5>CLÁUSULA NONA – RESPONSÁVEL PELO TRATAMENTO</h5>
          <p>Marco Antônio Mendes Pena Silva – Técnico – 140.971.486-13.</p>

          <h5>CLÁUSULA DÉCIMA – EXATIDÃO DOS DADOS</h5>
          <p>O usuário é responsável pela veracidade de suas informações.</p>

          <h5>CLÁUSULA DÉCIMA PRIMEIRA – TRANSPARÊNCIA</h5>
          <p>Demandas simples em até 48h; complexas em até 15 dias.</p>

          <h5>CLÁUSULA DÉCIMA SEGUNDA – DADOS DE CRIANÇAS E ADOLESCENTES</h5>
          <p>Tratamento conforme Art. 14 da LGPD, com proteção reforçada.</p>

          <h5>CLÁUSULA DÉCIMA TERCEIRA – DISPOSIÇÕES GERAIS</h5>
          <p>O Termo pode ser atualizado periodicamente.</p>

          <h5>CLÁUSULA DÉCIMA QUARTA – FORO</h5>
          <p>Belo Horizonte/MG.</p>

          <hr>

          <p><b>Belo Horizonte/MG, 24 de Outubro de 2025.</b></p>

          <p><b>Usuário(a):</b><br>____________________________________________</p>
          <p><b>Pelo Projeto Eletro-Descarte:</b><br>Diogo Rodrigues – Diretor – 170.080.576-28</p>

          <p><b>Testemunhas:</b><br>
            Marco Antônio Mendes Pena Silva – 140.971.486-13<br>
            Pedro Henrique Moreira Ferreira – 139.139.516-60<br>
            Gabriel Henrique Silva de Souza – 136.172.956-22
          </p>
        </div>
      </div>

      <div class="modal-footer">
        <button id="btnAceitar" class="btn btn-success" disabled>Li e Aceito os Termos</button>
      </div>

    </div>
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
