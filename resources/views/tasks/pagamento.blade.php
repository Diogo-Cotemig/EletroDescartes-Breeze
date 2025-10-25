<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagamento - Descarte Sustentável</title>
  @vite(['resources/css/pagamento.css'])
</head>
<body>

  <header>Pagamento - Serviço de Coleta</header>

  <main>
    <h2>Resumo do Pedido</h2>
    <div class="info">
      <p><strong>Distância:</strong> <span id="distancia">0 km</span></p>
      <p><strong>Valor por km:</strong> R$ <span id="valorKm">2,50</span></p>
      <p class="valor">Total: <span id="total">R$ 0,00</span></p>
    </div>

    <h2>Informações de Pagamento</h2>
    <form id="formPagamento">
      <label for="nome">Nome completo:</label>
      <input type="text" id="nome" required>

      <label for="email">E-mail:</label>
      <input type="email" id="email" required>

      <label for="cartao">Número do cartão:</label>
      <input type="text" id="cartao" maxlength="16" placeholder="0000 0000 0000 0000" required>

      <label for="validade">Validade:</label>
      <input type="month" id="validade" required>

      <label for="cvv">CVV:</label>
      <input type="text" id="cvv" maxlength="3" required>

      <button type="submit">Finalizar Pagamento</button>
    </form>

    <div id="sucesso">✅ Pagamento confirmado! Obrigado por contribuir com o meio ambiente.<br><br>Você será redirecionado à página inicial.</div>
  </main>

  <script>
    const distancia = parseFloat(sessionStorage.getItem("distancia") || "0");
    const valorPorKm = 2.5;
    const total = distancia * valorPorKm;

    document.getElementById("distancia").innerText = distancia.toFixed(2) + " km";
    document.getElementById("total").innerText = "R$ " + total.toFixed(2);

    const form = document.getElementById("formPagamento");
    const sucesso = document.getElementById("sucesso");

    form.addEventListener("submit", (e) => {
      e.preventDefault();
      sucesso.style.display = "block";
      form.style.display = "none";

      setTimeout(() => {
        window.location.href = "/";
      }, 4000);
    });
  </script>

</body>
</html>
