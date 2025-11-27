<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pagamento - Eletro Descarte</title>

    {{-- Fonte e CSS --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/pagamento.css'])
</head>
<body>
    <div class="container">
        <h2>Pagamento via PIX</h2>
        <p>Valor a pagar:
            <strong class="valor">R$ {{ number_format($valor, 2, ',', '.') }}</strong>
        </p>
        <p>Escaneie o QR Code abaixo ou copie o código PIX:</p>

        <div class="pix-code">
            PIX-CÓDIGO-{{ strtoupper(uniqid()) }}
        </div>

        <form method="POST" action="{{ route('pagamento.store') }}">
            @csrf
            <input type="hidden" name="agendamento_id" value="{{ $agendamento_id }}">
            <input type="hidden" name="valor" value="{{ $valor }}">
            <button type="submit" class="botao-pagar">Confirmar Pagamento</button>
        </form>
    </div>
</body>
</html>
