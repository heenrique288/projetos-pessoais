<?php
$host = "localhost";
$user = "root";
$senha = "";
$banco = "sistema_filmes";

$conn = new mysqli($host, $user, $senha, $banco);

if ($conn->connect_error) {
    die("Falha: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "SELECT * FROM filmes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($filme = $result->fetch_assoc()):
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($filme['nome']); ?></title>
    <link rel="stylesheet" href="src/css/informacoes.css">
    <link rel="stylesheet" href="src/css/global.css">
</head>
<body>
    <header>
        <h1>ONDE OS FRACOS NÃO TÊM VEZ</h1>
    </header>

    <main>
        <div class="informacoes_filme">
            <div class="imagem">
                <img src="<?php echo $filme['imagem']; ?>" alt="Imagem do Filme" class="filme">
            </div>
            <div class="informacao_do_filme">
                <div class="extras">
                    <p><strong>Nome do Filme: </strong><?php echo htmlspecialchars($filme['nome']); ?></p>
                    <p><strong>Diretor: </strong><?php echo htmlspecialchars($filme['diretor']); ?></p>
                    <p><strong>Duração: </strong><?php echo htmlspecialchars($filme['duracao']); ?></p>
                </div>
            </div>
        </div>

        <div class="espacamento"></div>

        <section>
            <p><?php echo nl2br(htmlspecialchars($filme['sinopse'])); ?></p>
        </section>

        <div class="espacamento"></div>

        <div class="voltar">
            <a href="index.php"><button>Voltar para a votação</button></a>
        </div>

        <div class="espacamento"></div>
    </main>

    <footer>
        <p>&copy; Este site foi desenvolvido por <a href="https://github.com/heenrique288">Henrique José Ferreira dos Santos</a></p>
    </footer>
</body>
</html>

<?php
else:
    echo "Filme não encontrado.";
endif;

$stmt->close();
$conn->close();
?>
