<?php
session_start();

// Conexão com o banco de dados
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_filmes";

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];

// Verifica se as senhas são iguais
if($senha !== $confirmar_senha) {
    $_SESSION['erro_cadastro'] = "As senhas não coincidem!";
    header("Location: cadastro.php");
    exit;
}

// Verifica se o e-mail já está cadastrado
$sql_verifica = "SELECT id FROM usuarios WHERE email = ?";
$stmt_verifica = $conn->prepare($sql_verifica);
$stmt_verifica->bind_param("s", $email);
$stmt_verifica->execute();
$stmt_verifica->store_result();

if($stmt_verifica->num_rows > 0) {
    $_SESSION['erro_cadastro'] = "Este e-mail já está cadastrado!";
    $stmt_verifica->close();
    $conn->close();
    header("Location: cadastro.php");
    exit;
}
$stmt_verifica->close();

// Criptografa a senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Prepara e executa o SQL
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $senha_hash);

if($stmt->execute()) {
    $_SESSION['sucesso_cadastro'] = "Cadastro realizado com sucesso!";
    header("Location: login.php");
    exit;
} else {
    $_SESSION['erro_cadastro'] = "Erro ao cadastrar: " . $stmt->error;
    header("Location: cadastro.php");
    exit;
}

$stmt->close();
$conn->close();
?>
