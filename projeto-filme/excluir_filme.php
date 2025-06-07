<?php
session_start();

if(!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if(isset($_GET['id'])){
    $filme_id = $_GET['id'];

    $conn = new mysqli("localhost", "root", "", "sistema_filmes");

    if($conn->connect_error){
        die("Erro: " . $conn->connect_error);
    }

    $sql = "DELETE FROM filmes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $filme_id);

    if($stmt->execute()){
        echo "<script>
            alert('Filme excluído com sucesso!');
            window.location.href = 'painel_filmes.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao excluir: " . $stmt->error . "');
            window.location.href = 'painel_filmes.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>
        alert('ID do filme não especificado!');
        window.location.href = 'painel_filmes.php';
    </script>";
}
?>
