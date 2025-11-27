<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegando os dados do formulário e sanitizando
    $nome = htmlspecialchars(trim($_POST["nome"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $telefone = htmlspecialchars(trim($_POST["telefone"]));
    $descricao = htmlspecialchars(trim($_POST["descricao"]));

    // Para quem será enviado
    $para = "12302260@aluno.cotemig.com.br";

    $assunto = "Nova Solicitação de Assistência Técnica";

    // Corpo do e-mail
    $mensagem = "Você recebeu uma nova solicitação de assistência técnica:\n\n";
    $mensagem .= "Nome: $nome\n";
    $mensagem .= "E-mail: $email\n";
    $mensagem .= "Telefone: $telefone\n";
    $mensagem .= "Descrição:\n$descricao\n";

    // Cabeçalhos
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Enviar
    if (mail($para, $assunto, $mensagem, $headers)) {
        echo "Solicitação enviada com sucesso!";
    } else {
        echo "Erro ao enviar. Tente novamente.";
    }
} else {
    echo "Método de envio inválido.";
}
?>