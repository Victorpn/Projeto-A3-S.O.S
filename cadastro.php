<?php
// 1. Configurações do Banco de Dados
$host = 'localhost'; // Seu host
$dbname = 'sos'; // Nome do seu banco de dados
$user = 'root'; // Seu usuário do BD
$pass = ''; // Sua senha do BD

// Nível de acesso que será atribuído a TODOS os usuários cadastrados por este formulário
$nivel_padrao = 'user'; 

try {
    // 2. Conexão com o Banco de Dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o formulário foi enviado
    if (isset($_POST['cadastrar'])) {
        
        // 3. Recebe e Sanitiza os dados do formulário
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha_pura = $_POST['senha'];

        // 4. Criptografa a Senha (MUITO IMPORTANTE para segurança)
        $senha_criptografada = password_hash($senha_pura, PASSWORD_DEFAULT);

        // 5. Query de Inserção com Prepared Statement
        // **ATENÇÃO:** O valor para nivel_acesso é fixo ('user')
        $sql = "INSERT INTO usuarios (nome, email, senha, nivel_acesso) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        // 6. Executa a Inserção
        // Os parâmetros são ligados na ordem: nome, email, senha_criptografada, nivel_padrao ('user')
        $stmt->execute([$nome, $email, $senha_criptografada, $nivel_padrao]);

        echo "✅ Usuário **$nome** cadastrado com sucesso! Nível de acesso: **$nivel_padrao**";
        
        // Redirecionamento após o sucesso
        // header("Location: login.php");
        // exit();

    } else {
        echo "❌ Acesso inválido. O formulário não foi enviado.";
    }

} catch (PDOException $e) {
    // 7. Trata erros (ex: e-mail já existe)
    if ($e->getCode() == 23000) { // Código de erro para chave única duplicada (e-mail)
        echo "❌ Erro: O e-mail **$email** já está cadastrado.";
    } else {
        echo "❌ Erro ao cadastrar: " . $e->getMessage();
    }
}
?>

<head>
    <link rel="stylesheet" href="estilo.css">
    <title>Cadastro de Usuário</title>
    <style>
        /* ------------------------------------- */
/* ESTILOS GERAIS DO CORPO (body) */
/* ------------------------------------- */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7f6; /* Cor de fundo suave */
    display: flex;
    justify-content: center; /* Centraliza horizontalmente */
    align-items: center; /* Centraliza verticalmente */
    min-height: 100vh; /* Ocupa a altura total da tela */
    margin: 0;
}

/* ------------------------------------- */
/* ESTILOS DO FORMULÁRIO */
/* ------------------------------------- */
form {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 10px; /* Bordas arredondadas */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Sombra suave */
    width: 100%;
    max-width: 400px; /* Largura máxima para formulários */
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 25px;
}

/* ------------------------------------- */
/* ESTILOS DOS CAMPOS (inputs e labels) */
/* ------------------------------------- */
label {
    display: block; /* Garante que o label ocupe sua própria linha */
    margin-bottom: 8px;
    color: #555;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: calc(100% - 20px); /* 100% menos o padding */
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box; /* Garante que padding e borda não aumentem a largura total */
    transition: border-color 0.3s;
}

input:focus {
    border-color: #007bff; /* Cor de destaque ao focar */
    outline: none; /* Remove o outline padrão do navegador */
}

/* ------------------------------------- */
/* ESTILOS DO BOTÃO */
/* ------------------------------------- */
button[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #28a745; /* Cor verde para sucesso/cadastro */
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #218838; /* Escurece no hover */
}
    </style>
    
</head>

<form action="cadastro.php" method="POST">
    <h2>Cadastrar Novo Usuário</h2>
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required><br><br>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required><br><br>

    <button type="submit" name="cadastrar">Cadastrar</button>
</form>