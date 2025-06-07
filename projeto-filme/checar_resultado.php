<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$senha = "";
$banco = "sistema_filmes";
$conn = new mysqli($host, $user, $senha, $banco);

if ($conn->connect_error) {
    echo json_encode(['mostrar_resultado' => false]);
    exit;
}

$sql = "SELECT mostrar_resultado FROM status_votacao WHERE id = 1";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

echo json_encode(['mostrar_resultado' => (bool)$data['mostrar_resultado']]);
$conn->close();
?>
