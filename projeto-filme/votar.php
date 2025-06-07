<?php
session_start();
$usuario_id = $_SESSION['usuario_id'];

$filme = (int) $_POST['filme'];

$host = "localhost";
$user = "root";
$senha = "";
$banco = "sistema_filmes";

$conn = new mysqli($host, $user, $senha, $banco);

if ($conn->connect_error) {
    die("Falha: " . $conn->connect_error);
}

// Verifica se o usuário já votou
$sql = "SELECT * FROM votos WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows > 0){
    echo "Você já votou!";
} else {
    // Insere o voto
    $sql = "INSERT INTO votos (usuario_id, filme) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $usuario_id, $filme);  // Agora ambos são inteiros
    if($stmt->execute()){
        echo "Voto computado com sucesso!";
    } else {
        echo "Erro ao computar voto.";
    }
}

$stmt->close();
$conn->close();
?>
