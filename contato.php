<?php
// Impede o cache para que as mensagens de status sejam sempre as mais recentes
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Verifica se o formulário foi enviado usando o método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- CONFIGURAÇÕES ---
    $email_destino = "contatombadvocacia@gmail.com"; // <<< !!! COLOQUE SEU E-MAIL AQUI !!!
    $nome_site = "MB Advocacia";
    // -------------------

    // Função para limpar e validar os dados
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Mais seguro
        return $data;
    }

    // Pega e limpa os dados do formulário
    $nome = clean_input($_POST["nome"]);
    $email = clean_input($_POST["email"]);
    $telefone = clean_input($_POST["telefone"]); // Pega o telefone também
    $assunto_form = clean_input($_POST["assunto"]);
    $mensagem = clean_input($_POST["mensagem"]);

    // Validação
    if (empty($nome) || empty($assunto_form) || empty($mensagem) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redireciona de volta com uma mensagem de erro
        header("Location: index.html?status=erro#contato");
        exit;
    }

    // Monta o assunto do e-mail
    $assunto_email = "Contato do Site ($nome_site): $assunto_form";

    // Monta o corpo do e-mail
    $corpo_email = "Você recebeu uma nova mensagem do formulário de contato:\n\n";
    $corpo_email .= "Nome: $nome\n";
    $corpo_email .= "E-mail: $email\n";
    if (!empty($telefone)) {
        $corpo_email .= "Telefone: $telefone\n";
    }
    $corpo_email .= "Assunto: $assunto_form\n";
    $corpo_email .= "Mensagem:\n$mensagem\n";

    // Monta os cabeçalhos - Essencial para o 'De:' e para evitar spam
    $cabecalhos = "From: $nome_site <nao-responda@mbadvocaciapr.com.br>\r\n"; // Use um e-mail do seu domínio se possível
    $cabecalhos .= "Reply-To: $email\r\n";
    $cabecalhos .= "MIME-Version: 1.0\r\n";
    $cabecalhos .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $cabecalhos .= "X-Mailer: PHP/" . phpversion();

    // Tenta enviar o e-mail
    if (mail($email_destino, $assunto_email, $corpo_email, $cabecalhos)) {
        // Redireciona de volta com uma mensagem de sucesso
        header("Location: index.html?status=sucesso#contato");
        exit;
    } else {
        // Redireciona de volta com uma mensagem de erro genérico
        header("Location: index.html?status=erro_envio#contato");
        exit;
    }

} else {
    // Se alguém tentar acessar o arquivo PHP diretamente, redireciona para a home
    header("Location: index.html");
    exit;
}
?>