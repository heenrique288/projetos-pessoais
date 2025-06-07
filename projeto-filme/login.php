<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/css/login.css">
</head>
<body>
    <div class="login">
        <h1>Login</h1>
        <?php

            if(isset($_SESSION['sucesso_cadastro'])) {
                echo '<p style="color: green;">' . htmlspecialchars($_SESSION['sucesso_cadastro']) . '</p>';
                unset($_SESSION['sucesso_cadastro']);
            }

            if(isset($_GET['erro'])) {
                echo '<p style="color: red;">' . htmlspecialchars($_GET['erro']) . '</p>';
            }
        ?>

        <form action="processa_login.php" method="POST">
            <input type="email" name="email" id="iemail" placeholder="E-mail" required>
            <input type="password" name="senha" id="isenha" placeholder="Senha" required>
            <br>
            <button type="submit">Entrar</button>
        </form>
        <p>Não tem uma conta?<br><a href="cadastro.php"> Faça seu cadastro</a></p>
    </div>
</body>
</html>