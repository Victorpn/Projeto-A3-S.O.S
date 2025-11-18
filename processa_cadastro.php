<?php
    // Credenciais de conexão (ajuste para o seu ambiente!)
$host = 'localhost'; 
$dbname = 'sos'; 
$user = 'root'; // ou seu_usuario_mysql
$pass = ''; // ou '' se for sem senha

// Nível padrão
$nivel_padrao = 'user'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Conexão bem-sucedida!
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>