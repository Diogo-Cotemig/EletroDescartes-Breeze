<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pagamento Confirmado</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; text-align: center; padding: 50px; background-color: #f9fff9; }
        .container { max-width: 500px; margin: auto; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        h2 { color: #2ecc71; }
    </style>
</head>
<body>
    <div class="container">
        <h2>✅ Pagamento Confirmado!</h2>
        <p>O pagamento do agendamento <strong>#{{ $pagamento->agendamento_id }}</strong> foi registrado com sucesso.</p>
        <p><strong>Valor pago:</strong> R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</p>
        <p><strong>Código PIX:</strong> {{ $pagamento->codigo_pix }}</p>
        <a href="{{ route('OndeDescarte') }}">Voltar</a>
    </div>
</body>
</html>
