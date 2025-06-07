<?php
session_start();

// Verifica se o admin está logado
if(!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Filme</title>
    <link rel="stylesheet" href="src/css/global.css">
    <link rel="stylesheet" href="src/css/cadastro_filme.css">
</head>
<body>
    <header>
        <h1>Cadastro de Filme</h1>
    </header>

    <main>
        <form action="salvar_filme.php" method="POST" enctype="multipart/form-data">
            <label>Nome do Filme:</label>
            <input type="text" name="nome" required><br>

            <label>Diretor:</label>
            <input type="text" name="diretor" required><br>

            <label>Duração:</label>
            <input type="text" name="duracao" required><br>

            <label>Sinopse:</label><br>
            <textarea name="sinopse" rows="5" cols="30" required></textarea><br>

            <label>Imagem (banner):</label>
            <input type="file" name="imagem" accept="image/*" required><br><br>

            <button type="submit">Salvar Filme</button>
        </form>
    </main>

    <footer>
        <p>&copy; Desenvolvido por <a href="https://github.com/heenrique288">Henrique José Ferreira dos Santos</a></p>
    </footer>
</body>
</html>
