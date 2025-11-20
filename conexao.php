<?php
$host = "localhost";
$usuario = "root"; // coloque seu usuário
$senha = "";       // coloque sua senha do MySQL
$banco = "sos";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
