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
$criticaError = "";

// Array de resposta
$response = array('success' => false, 'errors' => array());

// Verificar se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validação do campo critica
    $critica = sanitize_input($_POST["critica"]);
    if (empty($critica)) {
        $criticaError = "A sugestão não pode estar vazia.";
    }

    // Se não houver erros, processar os dados (por exemplo, salvar no banco de dados)
    if (empty($criticaError)) {
        // Conectar ao banco de dados
        require_once 'config.php';

        // Preparar e vincular
        $stmt = $conn->prepare("INSERT INTO criticas (conteudo) VALUES (?)");
        $stmt->bind_param("s", $critica);

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
        if (!empty($criticaError)) {
            $response['errors'][] = $criticaError;
        }
    }
} else {
    $response['errors'][] = "Método de requisição inválido.";
}

// Retornar a resposta como JSON
echo json_encode($response);
?>
