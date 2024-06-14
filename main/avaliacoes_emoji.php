<?php
//nao deixe nessa pagina se nao for post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $avaliacao = htmlspecialchars(trim($_POST['avaliacao']));
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
        <div class="buttons">
            <button class="btn" id="ruim">
                <img class="icon" src="/ProjetoIf/assets/bad.svg" alt="ruim">
                Ruim
            </button>
            <button class="btn" id="medio">
                <img class="icon" src="/ProjetoIf/assets/mid.svg" alt="medio">
                Médio
            </button>
            <button class="btn" id="bom">
                <img class="icon" src="/ProjetoIf/assets/good.svg" alt="bom">
                Bom
            </button>
        </div>
        <button class="add-feedback">Adicionar avaliação</button>
    </div>
    
    <div id="success-banner" class="hidden">Feedback enviado com sucesso!</div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('.btn');
        let selectedFeedback = '';
        const successBanner = document.getElementById('success-banner');
        const addFeedbackButton = document.querySelector('.add-feedback');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                buttons.forEach(btn => btn.classList.remove('selected'));
                button.classList.add('selected');
                selectedFeedback = button.id;
            });
        });

        addFeedbackButton.addEventListener('click', () => {
            if (selectedFeedback) {
                addFeedbackButton.classList.add('disabled');

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'enviar_feedback.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        successBanner.classList.add('visible');
                        setTimeout(() => {
                            successBanner.classList.remove('visible');
                            window.location.href = 'obrigado.html';
                        }, 3000);
                    }
                };
                xhr.send('feedback=' + encodeURIComponent(selectedFeedback) + '&nome=' + encodeURIComponent('<?php echo $nome; ?>') + '&avaliacao=' + encodeURIComponent('<?php echo $avaliacao; ?>'));
            } else {
                alert('Por favor, selecione uma opção de feedback.');
            }
        });
    });
    </script>
</body>
</html>
