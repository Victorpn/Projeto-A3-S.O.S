<?php
session_start();
require_once "conexao.php";

if (!isset($_POST['email']) || !isset($_POST['senha'])) {
    header("Location: login.php?error=1");
    exit;
}

$login = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT id, nome, email, senha, nivel_acesso 
        FROM usuarios 
        WHERE email = ? OR nome = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $login, $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    if (password_verify($senha, $usuario['senha'])) {

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_nivel'] = $usuario['nivel_acesso'];

        header("Location: menuUser.php");
        exit;
    }
}

header("Location: login.php?error=1");
exit;
?>
