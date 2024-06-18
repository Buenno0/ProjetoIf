<?php
// Incluir a configuração do banco de dados
require_once("config.php");

// Selecionar os dados da tabela feedback
$sql = "SELECT nome, feedback, conteudo, created_at FROM feedback WHERE visible = TRUE ORDER BY created_at DESC";
$result = $conn->query($sql);

$feedbacks = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
} else {
    echo "Nenhuma avaliação encontrada.";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliações - Instituto Federal</title>
    <link rel="stylesheet" href="/ProjetoIf/styles/style.css">
</head>
<body>
    <header>
        <a href="#"><img class="back-button" src="/ProjetoIf/assets/back-button.svg" alt="Voltar"></a>
        <img src="/ProjetoIf/assets/ifsp_logo_itp.png" alt="Instituto Federal" class="logo">
    </header>
    <div class="container_criticas">
        <h1 class="criticas_h1">Avaliações</h1>
        <a href="avaliacoes_user.php"><button class="add-review-button">Adicionar avaliação</button></a>
        <div class="reviews">
            <?php
            foreach ($feedbacks as $feedback) {
                $icon = '';
                switch ($feedback['feedback']) {
                    case 'bom':
                        $icon = 'good.svg';
                        break;
                    case 'médio':
                        $icon = 'neutro.svg';
                        break;
                    case 'ruim':
                        $icon = 'bad.svg';
                        break;
                }

                echo '<div class="review">';
                echo '    <div class="review-header">';
                echo '        <div class="user_name">';
                echo '            <img src="/ProjetoIf/assets/' . $icon . '" alt="' . $feedback['feedback'] . '" class="user-icon">';
                echo '            <span class="nome_span">' . htmlspecialchars($feedback['nome']) . '</span>';
                echo '        </div>';
                echo '        <span class="date">' . date('d/m/Y', strtotime($feedback['created_at'])) . '</span>';
                echo '    </div>';
                echo '    <p class="texto">' . htmlspecialchars($feedback['conteudo']) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
