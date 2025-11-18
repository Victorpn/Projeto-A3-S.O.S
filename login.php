<?php
// ===========================================
// Arquivo: login.php
// Objetivo: Mostrar o formulário de login para acesso restrito
// ===========================================

// 1. Definição de Variáveis PHP
$pagina_titulo = "Acesso Restrito - SOS Sul";
$mensagem_de_apoio = "Insira suas credenciais para gerenciar as doações e a logística.";

// 2. Lógica PHP (Se Necessária)
// Aqui poderia haver lógica para verificar se o usuário já está logado ou lidar com erros de login.
$erro_login = isset($_GET['error']) ? "Credenciais inválidas. Tente novamente." : "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pagina_titulo; ?></title>
    <!-- Assumindo que 'styles.css' existe, mas adicionando estilos inline para garantir a funcionalidade -->
    <link rel="stylesheet" href="styles.css" /> 
    <style>
        /* Reutilizando estilos base do doarAgora.php para consistência */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Garante que o footer fique no final da página */
        }
        .hero {
            background-color: #00529B; /* Azul Institucional */
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .hero h1 {
            font-size: 2.5em;
            margin: 0;
        }
        .hero p {
            font-size: 1.1em;
            margin-top: 10px;
        }
        .content {
            flex-grow: 1; /* Permite que o conteúdo ocupe o espaço restante */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .login-form-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        .login-form-container h2 {
            text-align: center;
            color: #00529B;
            margin-bottom: 25px;
        }
        .login-form-container label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #333;
        }
        .login-form-container input[type="text"],
        .login-form-container input[type="password"],
        .login-form-container input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box; 
            transition: border-color 0.3s;
        }
        .login-form-container input:focus {
            border-color: #FFA500; /* Laranja de destaque */
            outline: none;
        }
        .button {
            margin-top: 25px;
            padding: 12px 20px;
            width: 100%;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .primary {
            background-color: #FFA500; /* Botão de ação primária */
            color: white;
        }
        .primary:hover {
            background-color: #ff9900;
        }
        .error-message {
            color: red;
            background-color: #fee;
            border: 1px solid red;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
        .forgot-password {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #00529B;
            text-decoration: none;
            font-size: 0.9em;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
        footer {
            text-align: center;
            padding: 20px;
            margin-top: auto; /* Empurra o footer para o final */
            color: #888;
        }
    </style>
</head>
<body>
    <header class="hero">
        <h1><?php echo $pagina_titulo; ?></h1>
        <p><?php echo $mensagem_de_apoio; ?></p>
    </header>

    <main class="content">
        <div class="login-form-container">
            <h2>Acesso à Plataforma</h2>
            
            <?php if ($erro_login): ?>
                <p class="error-message"><?php echo $erro_login; ?></p>
            <?php endif; ?>

            <form action="processar_login.php" method="POST">
                
                <label for="email">E-mail ou Usuário:</label>
                <input type="email" id="email" name="email" required>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>

                <button type="submit" class="button primary">Entrar</button>

                <a href="" class="forgot-password">Solicitar reset de senha</a>
                <a href="cadastro.php" class="forgot-password">Cadastra-se</a>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 SOS Sul. Solidariedade em Ação.</p>
    </footer>
</body>
</html>