<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/contato.css'])
  <title>EletroDescarte - Descarte Eletrônico Sustentável</title>
  <link rel="icon" type="image/png" href="{{ asset('img/Eletro-DescarteLOGO.png') }}">
</head>
<body>

<button onclick="window.location.href='/logado'" id="botao_sair">
   <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 640 640">
    <path d="M73.4 297.4C60.9 309.9 60.9 330.2 73.4 342.7L233.4 502.7C245.9 515.2 266.2 515.2 278.7 502.7C291.2 490.2 291.2 469.9 278.7 457.4L173.3 352L544 352C561.7 352 576 337.7 576 320C576 302.3 561.7 288 544 288L173.3 288L278.7 182.6C291.2 170.1 291.2 149.8 278.7 137.3C266.2 124.8 245.9 124.8 233.4 137.3L73.4 297.3z"/></svg>
</button>

    <div class="container">

    <h1 id="Nome_assistencia">Assistência Técnica</h1>

        <form action="assistencia.php" method="POST">



                <label for="nome">Nome:</label>
                <input type="text" name="nome" placeholder="Escreva o nome" required>

                <label for="email">E-mail:</label>
                <input type="email" name="email" placeholder="Escreva o E-mail" required>

                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" placeholder="Escreva o telefone">

                <label for="descricao">Descrição do problema:</label>
                <textarea name="descricao" rows="5" required placeholder="Escreva o problema"></textarea>

                <button type="submit">Enviar Solicitação</button>

        </form>

    </div>

<script>

    const telefoneInput = document.getElementById('telefone');

    telefoneInput.addEventListener('input', function () {
      let telefone = telefoneInput.value.replace(/\D/g, '');

      if (telefone.length > 11) {
        telefone = telefone.slice(0, 11);
      }

      if (telefone.length <= 10) {
        telefone = telefone.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
      } else {
        telefone = telefone.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
      }

      telefoneInput.value = telefone;
    });

</script>

</body>
</html>


