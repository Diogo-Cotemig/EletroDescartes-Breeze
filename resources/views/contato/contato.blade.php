<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Mensagem de Contato</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">📧 Nova Mensagem de Contato</h1>
                            <p style="color: #ffffff; margin: 10px 0 0 0; opacity: 0.9;">Eletro Descarte</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #333; font-size: 16px; margin: 0 0 20px 0;">Você recebeu uma nova mensagem através do formulário de contato:</p>

                            <table width="100%" cellpadding="10" style="border: 1px solid #e0e0e0; border-radius: 5px; margin-bottom: 20px;">
                                <tr style="background-color: #f9f9f9;">
                                    <td style="color: #666; font-weight: bold; width: 30%;">Nome:</td>
                                    <td style="color: #333;">{{ $nome_completo }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #666; font-weight: bold;">Email:</td>
                                    <td style="color: #333;">
                                        <a href="mailto:{{ $email }}" style="color: #667eea; text-decoration: none;">{{ $email }}</a>
                                    </td>
                                </tr>
                                <tr style="background-color: #f9f9f9;">
                                    <td style="color: #666; font-weight: bold;">Telefone:</td>
                                    <td style="color: #333;">{{ $telefone }}</td>
                                </tr>
                            </table>

                            <div style="background-color: #f9f9f9; padding: 20px; border-left: 4px solid #667eea; border-radius: 5px; margin-bottom: 20px;">
                                <h3 style="color: #333; margin: 0 0 10px 0; font-size: 16px;">Mensagem:</h3>
                                <p style="color: #555; line-height: 1.6; margin: 0; white-space: pre-wrap;">{{ $mensagem }}</p>
                            </div>

                            <p style="color: #666; font-size: 14px; margin: 20px 0 0 0;">
                                <strong>⏰ Data de envio:</strong> {{ date('d/m/Y H:i') }}
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9f9f9; padding: 20px; text-align: center; border-top: 1px solid #e0e0e0;">
                            <p style="color: #999; font-size: 12px; margin: 0;">
                                Este email foi enviado automaticamente pelo sistema de contato do site Eletro Descarte.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
