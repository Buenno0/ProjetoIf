<?php
require_once("main/config.php");

// Insere o registro na tabela denuncia
$sql = "INSERT INTO denuncia (usado_em) VALUES (CURRENT_TIMESTAMP)";

if ($conn->query($sql) === TRUE) {
    echo "Nova denúncia registrada com sucesso";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

// Fecha a conexão
$conn->close();

