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
$email = $_POST['email'];
$senha = $_POST['senha'];

// Prepara e executa o SQL
$sql = "SELECT id, nome, senha, tipo FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

// Pega o resultado
$resultado = $stmt->get_result();

if($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    // Verifica se a senha está correta
    if(password_verify($senha, $usuario['senha'])) {
        // Guarda informações na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];  // importante!

        // Redireciona conforme o tipo
        if($usuario['tipo'] === 'admin') {
            header("Location: painel_filmes.php");
            exit;
        } else {
            header("Location: index.php");
            exit;
        }

    } else {
        // Senha incorreta
        header("Location: login.php?erro=Senha+incorreta");
        exit;
    }
} else {
    // Email não encontrado
    header("Location: login.php?erro=Email+nao+encontrado");
    exit;
}

$stmt->close();
$conn->close();
?>
