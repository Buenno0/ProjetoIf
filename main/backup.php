<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome']) && isset($_POST['avaliacao'])) {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $avaliacao = htmlspecialchars(trim($_POST['avaliacao']));
} else {
    header('Location: avaliacoes_user.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProjetoIf/styles/style.css">
    <title>Feedback</title>
</head>
<body>
    <header>
        <img src="/ProjetoIf/assets/ifsp_logo_itp.png" alt="Instituto Federal" class="logo">
    </header>
    <div class="container">
        <h1>Deixe sua avaliação</h1>
        <form action="enviar_feedback.php" method="post">
            <input type="hidden" name="nome" value="<?= $nome; ?>">
            <input type="hidden" name="avaliacao" value="<?= $avaliacao; ?>">
            <div class="buttons">
                <button type="button" class="btn" id="ruim">
                    <img class="icon" src="/ProjetoIf/assets/bad.svg" alt="ruim">
                    Ruim
                </button>
                <button type="button" class="btn" id="médio">
                    <img class="icon" src="/ProjetoIf/assets/mid.svg" alt="medio">
                    Médio
                </button>
                <button type="button" class="btn" id="bom">
                    <img class="icon" src="/ProjetoIf/assets/good.svg" alt="bom">
                    Bom
                </button>
            </div>
            <input type="hidden" name="feedback" id="selectedFeedback">
            <button type="submit" class="add-feedback">Adicionar avaliação</button>
        </form>
        <div id="error-banner" class="hidden">Por favor, selecione uma das opções.</div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('.btn');
        let selectedFeedback = '';
        const errorBanner = document.getElementById('error-banner');
        const feedbackInput = document.getElementById('selectedFeedback');
        const form = document.querySelector('form');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                buttons.forEach(btn => btn.classList.remove('selected'));
                button.classList.add('selected');
                selectedFeedback = button.id;
                feedbackInput.value = selectedFeedback;
            });
        });

        form.addEventListener('submit', (event) => {
            if (!selectedFeedback) {
                event.preventDefault();
                errorBanner.classList.add('visible');
                setTimeout(() => {
                    errorBanner.classList.remove('visible');
                }, 1300);
            }
        });
    });
    </script>
</body>
</html>