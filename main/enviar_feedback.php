<?php
session_start();
require_once("config.php");

// Verificar se a requisição é POST e se os parâmetros estão presentes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback']) && isset($_POST['nome']) && isset($_POST['avaliacao'])) {
    $feedback = htmlspecialchars(trim($_POST['feedback']));
    $nome = htmlspecialchars(trim($_POST['nome']));
    $avaliacao = htmlspecialchars(trim($_POST['avaliacao']));

    // Preparar a consulta SQL
    $stmt = $conn->prepare("INSERT INTO feedback (nome, feedback, conteudo) VALUES (?, ?, ?)");

    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    // Vincular os parâmetros
    $stmt->bind_param("sss", $nome, $feedback, $avaliacao);

    // Executar a consulta
    if ($stmt->execute()) {
        echo "Avaliação salva com sucesso!";
    } else {
        echo "Erro ao salvar avaliação: " . $stmt->error;
    }

    // Fechar a consulta e a conexão
    $stmt->close();
    $conn->close();
} else {
    echo "Requisição inválida.";
}
?>
