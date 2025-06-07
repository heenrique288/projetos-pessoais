<?php
session_start();
if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

$host = "localhost";
$user = "root";
$senha = "";
$banco = "sistema_filmes";

$conn = new mysqli($host, $user, $senha, $banco);

if ($conn->connect_error) {
    die("Falha: " . $conn->connect_error);
}

$sql = "SELECT * FROM filmes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onde os Fracos Não Têm Vez</title>
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
    <header>
        <h1>ONDE OS FRACOS NÃO TÊM VEZ</h1>
    </header>

    <main>
        <form action="votar.php" method="POST" id="formVoto">
            <?php while($filme = $result->fetch_assoc()): ?>
                <div>
                    <a href="informacoes.php?id=<?php echo $filme['id']; ?>">
                        <img src="<?php echo $filme['imagem']; ?>" alt="<?php echo htmlspecialchars($filme['nome']); ?>">
                    </a>
                    <label class="votar">
                        <input type="radio" name="filme" value="<?php echo $filme['id']; ?>" data-nome="<?php echo htmlspecialchars($filme['nome']); ?>">
                        Votar
                    </label>
                </div>
            <?php endwhile; ?>

            <div class="espacamento"></div>

            <div class="botao">
                <button type="submit">ENVIAR</button>

                <?php if(isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin'): ?>
                    <a href="mostrar_resultado.php"><button type="button">Mostrar Resultado</button></a>
                <?php endif; ?>
            </div>

            <div class="espacamento2"></div>
        </form>
    </main>

    <footer>
        <p>&copy; Este site foi desenvolvido por <a href="https://github.com/heenrique288">Henrique José Ferreira dos Santos</a></p>
    </footer>

    <script src="src/js/enviar.js"></script>
    <script>
    setInterval(() => {
        fetch('checar_resultado.php')
            .then(res => res.json())
            .then(data => {
                if (data.mostrar_resultado) {
                    window.location.href = 'resultado.php';
                }
            });
    }, 3000); // verifica a cada 3 segundos
    </script>

</body>
</html>

<?php $conn->close(); ?>
