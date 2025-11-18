<?php
// ===========================================
// Arquivo: config.php
// Objetivo: Definir as constantes de conexão com o banco de dados
// ===========================================

// Credenciais do Banco de Dados
define('DB_HOST', 'localhost'); // Geralmente é 'localhost'
define('DB_USER', 'root'); // MUDAR: Seu usuário do MariaDB/MySQL
define('DB_PASS', ''); // MUDAR: Sua senha do MariaDB/MySQL
define('DB_NAME', 'sos'); // MUDAR: O nome do seu banco de dados (ex: 'sos')

// Tentativa de conexão
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configura o PDO para retornar arrays associativos por padrão
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Em um ambiente de produção, registre o erro e mostre uma mensagem genérica
    // Em desenvolvimento, mostre o erro completo para depuração
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}