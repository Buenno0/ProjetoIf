<?php
// Configurações do servidor
header('Content-Type: application/json; charset=utf-8');

// Função para sanitizar dados
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Variáveis para armazenar erros
$nomeError = $emailError = $sugestaoError = "";

// Array de resposta
$response = array('success' => false, 'errors' => array());

// Verificar se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação do campo nome
    $nome = sanitize_input($_POST["nome"]);
    if (empty($nome)) {
        $nome = "Anônimo";
    }

    if (!empty($nome) && strlen($nome) > 50) {
        $nomeError = "O nome deve ter no máximo 50 caracteres.";
    }

    // Validação do campo e-mail
    $email = sanitize_input($_POST["email"]);
    if (empty($email)) {
        $emailError = "E-mail é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Por favor, insira um e-mail válido.";
    }

    // Validação do campo sugestão
    $sugestao = sanitize_input($_POST["sugestao"]);
    if (empty($sugestao)) {
        $sugestaoError = "A sugestão não pode estar vazia.";
    }

    // Se não houver erros, processar os dados (por exemplo, salvar no banco de dados)
    if (empty($nomeError) && empty($emailError) && empty($sugestaoError)) {
        // Conectar ao banco de dados
        require_once 'config.php';

        // Preparar e vincular
        $stmt = $conn->prepare("INSERT INTO sugestoes (nome, email, conteudo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $sugestao);

        // Executar e verificar se a inserção foi bem-sucedida
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['errors'][] = "Erro: " . $stmt->error;
        }

        // Fechar conexões
        $stmt->close();
        $conn->close();
    } else {
        // Coletar mensagens de erro
        if (!empty($nomeError)) {
            $response['errors'][] = $nomeError;
        }
        if (!empty($emailError)) {
            $response['errors'][] = $emailError;
        }
        if (!empty($sugestaoError)) {
            $response['errors'][] = $sugestaoError;
        }
    }
} else {
    $response['errors'][] = "Método de requisição inválido.";
}

// Retornar a resposta como JSON
echo json_encode($response);
?>
