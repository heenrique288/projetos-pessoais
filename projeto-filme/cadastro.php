<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="src/css/cadastro.css">
</head>
<body>
    <div class="register-container">
        <h2>Cadastro</h2>

        <?php
            if(isset($_SESSION['erro_cadastro'])) {
                echo '<p style="color: red;">' . htmlspecialchars($_SESSION['erro_cadastro']) . '</p>';
                unset($_SESSION['erro_cadastro']);
            }
        ?>

        <form action="cadastrar.php" method="POST">
            <input type="text" name="nome" placeholder="Nome Completo" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="password" name="confirmar_senha" placeholder="Confirmar Senha" required>
            <button type="submit">Cadastrar</button>
        </form>

        <p>Não tem uma conta?<br><a href="cadastro.html"> Faça seu cadastro</a></p>
  </div>
</body>
</html>