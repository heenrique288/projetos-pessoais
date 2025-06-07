<?php
// Apenas o admin pode acessar isso (coloque verificação se quiser)

$host = "localhost";
$user = "root";
$senha = "";
$banco = "sistema_filmes";
$conn = new mysqli($host, $user, $senha, $banco);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$sql = "UPDATE status_votacao SET mostrar_resultado = TRUE WHERE id = 1";
$conn->query($sql);

$conn->close();

// Redireciona para a tela de resultado do admin
header("Location: resultado.php");
exit;
?>
