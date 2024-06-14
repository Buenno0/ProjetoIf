<?php
// Configurar as informações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teste";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}