<?php
session_start();

// Verifica se o admin está logado
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

$sql = "SELECT * FROM filmes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Filmes</title>
    <link rel="stylesheet" href="src/css/painel_filmes.css">
    <link rel="stylesheet" href="src/css/global.css">
</head>
<body>

<header>
    <h1>Painel de Administração - Filmes</h1>
</header>

<main>
    <a href="index.php"><button>Ir para a votação</button></a>
    <a href="cadastro_filme.php"><button>Adicionar Novo Filme</button></a>

    <table>
        <thead>
            <tr>
                <th>Banner</th>
                <th>Nome</th>
                <th>Diretor</th>
                <th>Duração</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($filme = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?php echo $filme['imagem']; ?>" alt="Imagem" width="100"></td>
                    <td><?php echo htmlspecialchars($filme['nome']); ?></td>
                    <td><?php echo htmlspecialchars($filme['diretor']); ?></td>
                    <td><?php echo htmlspecialchars($filme['duracao']); ?></td>
                    <td>
                        <a href="editar_filme.php?id=<?php echo $filme['id']; ?>">Editar</a> | 
                        <a href="excluir_filme.php?id=<?php echo $filme['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este filme?');">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<footer>
    <p> &copy; Desenvolvido por <a href="https://github.com/heenrique288">Henrique José Ferreira dos Santos</a></p>
</footer>

</body>
</html>
