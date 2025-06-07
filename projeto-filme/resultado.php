<?php
session_start();

// Conexão com o banco de dados
$host = "localhost";
$user = "root";
$senha = "";
$banco = "sistema_filmes";

$conn = new mysqli($host, $user, $senha, $banco);

if ($conn->connect_error) {
    die("Falha: " . $conn->connect_error);
}

// Consulta para buscar o filme vencedor
$sql = "SELECT f.id, f.nome, f.imagem, COUNT(v.id) AS total_votos
        FROM votos v
        JOIN filmes f ON v.filme = f.id
        GROUP BY f.id, f.nome, f.imagem
        ORDER BY total_votos DESC
        LIMIT 1";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Votação</title>
    <link rel="stylesheet" href="src/css/global.css">
</head>
<body>

<header>
    <h1>Resultado da Votação</h1>
</header>

<main>

    <?php
    if ($result->num_rows > 0) {
        $vencedor = $result->fetch_assoc();
        echo "<h2>Filme Vencedor: " . htmlspecialchars($vencedor['nome']) . "</h2>";
        echo "<img src='" . htmlspecialchars($vencedor['imagem']) . "' alt='Imagem do Filme' width='200'><br>";
        echo "<p>Total de Votos: " . $vencedor['total_votos'] . "</p>";
    } else {
        echo "<p>Ainda não há votos registrados ou filme não encontrado.</p>";
    }
    ?>

    <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin'): ?>
        <div style="margin-top:20px;">
            <button id="btnFinalizar">Finalizar Votação</button>
        </div>

        <script>
        document.getElementById('btnFinalizar').addEventListener('click', function() {
            if (confirm("Tem certeza que deseja finalizar a votação?")) {
                fetch('finalizar_votacao.php', {
                    method: 'POST'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Erro ao finalizar votação.");
                    }
                    return response.text();
                })
                .then(text => {
                    if (text.trim() === "ok") {
                        window.location.href = "index.php";
                    } else {
                        alert("Erro: " + text);
                    }
                })
                .catch(error => {
                    alert("Erro: " + error.message);
                });
            }
        });
        </script>
    <?php else: ?>
        <script>
        // Para usuários comuns: verifica se a votação foi finalizada
        setInterval(() => {
            fetch('checar_resultado.php')
                .then(res => res.json())
                .then(data => {
                    if (data.status === "encerrada") {
                        window.location.href = "index.php";
                    }
                });
        }, 3000); // a cada 3 segundos
        </script>
    <?php endif; ?>

</main>

<footer>
    <p>&copy; Desenvolvido por Henrique José Ferreira dos Santos</p>
</footer>

</body>
</html>

<?php
$conn->close();
?>
