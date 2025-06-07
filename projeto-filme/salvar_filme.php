<?php
$host = "localhost";
$user = "root";
$senha = "";
$banco = "sistema_filmes";

$conn = new mysqli($host, $user, $senha, $banco);

if ($conn->connect_error) {
    die("Falha: " . $conn->connect_error);
}

$nome = $_POST['nome'];
$diretor = $_POST['diretor'];
$duracao = $_POST['duracao'];
$sinopse = $_POST['sinopse'];

// Upload da imagem
$target_dir = "src/img/";
$target_file = $target_dir . basename($_FILES["imagem"]["name"]);

if(move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
    $imagem = $target_file;

    $sql = "INSERT INTO filmes (nome, diretor, duracao, sinopse, imagem) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $diretor, $duracao, $sinopse, $imagem);

    if($stmt->execute()){
        echo "<script>alert('Filme cadastrado com sucesso!'); window.location.href='cadastro_filme.php';</script>";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Erro ao fazer upload da imagem.";
}

$conn->close();
?>
