<?php
session_start();
if(!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$user = "root";
$senha = "";
$banco = "sistema_filmes";

$conn = new mysqli($host, $user, $senha, $banco);

if($conn->connect_error){
    die("Falha: " . $conn->connect_error);
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM filmes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        $filme = $result->fetch_assoc();
    } else {
        echo "Filme não encontrado!";
        exit;
    }
    
    $stmt->close();
} else {
    echo "ID não especificado!";
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $diretor = $_POST['diretor'];
    $duracao = $_POST['duracao'];
    $sinopse = $_POST['sinopse'];
    $banner = $_POST['imagem'];

    $sql = "UPDATE filmes SET nome = ?, diretor = ?, duracao = ?, sinopse = ?, imagem = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nome, $diretor, $duracao, $sinopse, $banner, $id);

    if($stmt->execute()){
        echo "<script>
            alert('Filme editado com sucesso!');
            window.location.href = 'painel_filmes.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Erro ao atualizar: " . $stmt->error . "');
            window.location.href = 'painel_filmes.php';
        </script>";
    }


    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Filme</title>
    <link rel="stylesheet" href="src/css/cadastro_filme.css">
    <link rel="stylesheet" href="src/css/global.css">
</head>
<body>

<header>
    <h1>Editar Filme</h1>
</header>

<main>
    <form action="" method="POST">
        <label for="nome">Nome do Filme:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($filme['nome']); ?>" required>

        <label for="diretor">Diretor:</label>
        <input type="text" id="diretor" name="diretor" value="<?php echo htmlspecialchars($filme['diretor']); ?>" required>

        <label for="duracao">Duração:</label>
        <input type="text" id="duracao" name="duracao" value="<?php echo htmlspecialchars($filme['duracao']); ?>" required>

        <label for="sinopse">Sinopse:</label>
        <textarea id="sinopse" name="sinopse" rows="5" required><?php echo htmlspecialchars($filme['sinopse']); ?></textarea>

        <label for="imagem">URL do Imagem:</label>
        <input type="text" id="imagem" name="imagem" value="<?php echo htmlspecialchars($filme['imagem']); ?>" required>

        <button type="submit">Salvar Alterações</button>
    </form>
</main>

<footer>
    <p> &copy; Desenvolvido por Henrique José Ferreira dos Santos</p>
</footer>

</body>
</html>
