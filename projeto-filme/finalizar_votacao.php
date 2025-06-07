<?php
session_start();

$host = "localhost";
$user = "root";
$senha = "";
$banco = "sistema_filmes";

$conn = new mysqli($host, $user, $senha, $banco);

if ($conn->connect_error) {
   die("Falha: " . $conn->connect_error);
}

$sql = "DELETE FROM votos";
$conn->query("UPDATE status_votacao SET mostrar_resultado = FALSE WHERE id = 1");
if ($conn->query($sql)) {
    echo "ok"; // resposta simples para o JavaScript saber que funcionou
} else {
    http_response_code(500);
    echo "Erro ao finalizar votação.";
}

$conn->close();
?>
