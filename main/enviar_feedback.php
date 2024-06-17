<?php
session_start();
require_once("config.php");

// Função para verificar se o feedback é repetido
function isFeedbackRepetido($nome, $avaliacao) {
    return isset($_SESSION['ultimo_feedback']) &&
           $_SESSION['ultimo_feedback']['nome'] === $nome &&
           $_SESSION['ultimo_feedback']['avaliacao'] === $avaliacao;
}

// Verificar se a requisição é POST e se os parâmetros estão presentes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback']) && isset($_POST['nome']) && isset($_POST['avaliacao'])) {
    $feedback = htmlspecialchars(trim($_POST['feedback']));
    $nome = htmlspecialchars(trim($_POST['nome']));
    $avaliacao = htmlspecialchars(trim($_POST['avaliacao']));

    if ($nome === '') {
        $nome = "Anônimo";
    }

    // Verificar se o feedback já foi enviado recentemente
    if (isFeedbackRepetido($nome, $avaliacao)) {
        echo json_encode(['success' => false, 'message' => 'Feedback já enviado anteriormente.']);
        exit();
    }

    // Preparar a consulta SQL para inserção
    $stmt = $conn->prepare("INSERT INTO feedback (nome, feedback, conteudo) VALUES (?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Erro na preparação da consulta: ' . $conn->error]);
        exit();
    }

    // Vincular os parâmetros
    $stmt->bind_param("sss", $nome, $feedback, $avaliacao);

    // Executar a consulta
    if ($stmt->execute()) {
        // Armazenar o último feedback enviado na sessão
        $_SESSION['ultimo_feedback'] = [
            'nome' => $nome,
            'feedback' => $feedback,
            'avaliacao' => $avaliacao
        ];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar avaliação: ' . $stmt->error]);
    }

    // Fechar a consulta e a conexão
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
}
?>
