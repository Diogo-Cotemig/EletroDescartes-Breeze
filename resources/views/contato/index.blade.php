<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Eletro Descarte</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 900px;
            width: 100%;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .contact-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .contact-info h2 {
            font-size: 2em;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .contact-info p {
            font-size: 1em;
            margin-bottom: 30px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }

        .info-item:hover {
            transform: translateX(10px);
        }

        .info-item i {
            font-size: 1.5em;
            margin-right: 15px;
            background: rgba(255, 255, 255, 0.2);
            padding: 12px;
            border-radius: 10px;
        }

        .contact-form {
            padding: 60px 40px;
        }

        .contact-form h2 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.8em;
        }

        .contact-form .subtitle {
            color: #666;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all 0.3s;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }

            .contact-info {
                padding: 40px 30px;
            }

            .contact-form {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Informações de Contato -->
        <div class="contact-info">
            <h2>Entre em Contato</h2>
            <p>Tem alguma dúvida ou precisa de ajuda? Estamos aqui para você! Preencha o formulário e entraremos em contato o mais breve possível.</p>

            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <strong>Email</strong><br>
                    eletrodescartebh@gmail.com
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-phone"></i>
                <div>
                    <strong>Telefone</strong><br>
                    (31) 97126-7558
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <strong>Localização</strong><br>
                    Belo Horizonte, MG
                </div>
            </div>
        </div>

        <!-- Formulário -->
        <div class="contact-form">
            <h2>Envie sua Mensagem</h2>
            <p class="subtitle">Responderemos em até 24 horas</p>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('contato.enviar') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nome">Nome *</label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>
                    @error('nome')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sobrenome">Sobrenome *</label>
                    <input type="text" id="sobrenome" name="sobrenome" value="{{ old('sobrenome') }}" required>
                    @error('sobrenome')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder="(31) 99999-9999">
                    @error('telefone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="mensagem">Mensagem *</label>
                    <textarea id="mensagem" name="mensagem" required>{{ old('mensagem') }}</textarea>
                    @error('mensagem')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Enviar Mensagem
                </button>
            </form>
        </div>
    </div>
</body>
</html>
