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
        <button class="add-review-button">Adicionar avaliação</button>
        <div class="reviews">
            <?php
           require_once 'config.php';

            // Consultar os dados da tabela feedback
            $sql = "SELECT nome, conteudo, feedback, created_at FROM feedback order by created_at desc";
            $result = $conn->query($sql);

            

            if ($result->num_rows > 0) {
                // Exibir os dados de cada linha
                while($row = $result->fetch_assoc()) {
                    echo '<div class="review">';
                    echo '    <div class="review-header">';
                    echo '        <div class="user_name">';
                    echo '            <img src="/ProjetoIf/assets/mid.svg" alt="User Icon" class="user-icon">';
                    echo '            <span>' . htmlspecialchars($row['nome']) . '</span>';
                    echo '        </div>';
                    echo '        <span class="date">' . htmlspecialchars($row['created_at']) . '</span>';
                    echo '    </div>';
                    echo '    <p>' . nl2br(htmlspecialchars($row['conteudo'])) . '</p>';
                    echo '</div>';
                }
            } else {
                echo "<p>Nenhuma avaliação encontrada.</p>";
            }

            // Fechar a conexão
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
