
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instituto Federal - Avaliação</title>
    <link rel="stylesheet" href="/ProjetoIf/styles/style.css">
</head>
<body>
    <header>
        <img src="/ProjetoIf/assets/ifsp_logo_itp.png" alt="Instituto Federal" class="logo">
    </header>
    <div class="container">
        <h1>Deixe sua Avaliação</h1>
        <form id="feedbackForm" action="avaliacoes_emoji.php" method="post">
            <label for="nome">Nome (opcional):</label>
            <input type="text" id="nome" name="nome" maxlength="50">
            <div id="nomeError" class="error-message">O nome deve ter no máximo 50 caracteres.</div>
            
            <textarea name="avaliacao" id="avaliacao" placeholder="Conte como foi sua experiência"></textarea>
            <div id="avaliacaoError" class="error-message">A avaliação não pode estar vazia.</div>
            
            <button class="add-feedback" type="submit">Próximo</button>
        </form>
    </div>   
</body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('feedbackForm');
        const nome = document.getElementById('nome');
        const avaliacao = document.getElementById('avaliacao');
        const nomeError = document.getElementById('nomeError');
        const avaliacaoError = document.getElementById('avaliacaoError');

        form.addEventListener('submit', function(event) {
            let valid = true;

            // Reset error states
            nome.classList.remove('error');
            avaliacao.classList.remove('error');
            nomeError.style.display = 'none';
            avaliacaoError.style.display = 'none';

            // Validação do campo nome
            if (nome.value.length > 50) {
                nome.classList.add('error');
                nomeError.style.display = 'block';
                nome.focus();
                valid = false;
            }

            // Validação do campo avaliação
            if (avaliacao.value.trim() === '') {
                avaliacao.classList.add('error');
                avaliacaoError.style.display = 'block';
                avaliacao.focus();
                valid = false;
            }

            // Se as validações não passarem, previne o envio do formulário
            if (!valid) {
                event.preventDefault();
            }
        });
    });
</script>
