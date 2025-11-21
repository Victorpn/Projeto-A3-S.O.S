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
        
        // OBS: No próximo passo (Commit 6), vamos capturar os dados de endereço aqui!
        // $cep = $_POST['cep']; ...

        // 4. Criptografa a Senha (MUITO IMPORTANTE para segurança)
        $senha_criptografada = password_hash($senha_pura, PASSWORD_DEFAULT);

        // 5. Query de Inserção com Prepared Statement
        // **ATENÇÃO:** O valor para nivel_acesso é fixo ('user')
        $sql = "INSERT INTO usuarios (nome, email, senha, nivel_acesso) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        // 6. Executa a Inserção
        // Os parâmetros são ligados na ordem: nome, email, senha_criptografada, nivel_padrao ('user')
        $stmt->execute([$nome, $email, $senha_criptografada, $nivel_padrao]);

        echo "<div style='text-align:center; padding:10px; background:#d4edda; color:#155724; margin: 10px auto; max-width:400px; border-radius:5px;'>✅ Usuário **$nome** cadastrado com sucesso!</div>";
        
        // Redirecionamento após o sucesso
        // header("Location: login.php");
        // exit();

    } else {
        // echo "❌ Acesso inválido. O formulário não foi enviado.";
    }

} catch (PDOException $e) {
    // 7. Trata erros (ex: e-mail já existe)
    if ($e->getCode() == 23000) { // Código de erro para chave única duplicada (e-mail)
        echo "<div style='text-align:center; padding:10px; background:#f8d7da; color:#721c24; margin: 10px auto; max-width:400px; border-radius:5px;'>❌ Erro: O e-mail **$email** já está cadastrado.</div>";
    } else {
        echo "❌ Erro ao cadastrar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <style>
        /* ------------------------------------- */
        /* ESTILOS GERAIS DO CORPO (body) */
        /* ------------------------------------- */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6; /* Cor de fundo suave */
            display: flex;
            flex-direction: column;
            align-items: center; /* Centraliza verticalmente */
            min-height: 100vh; /* Ocupa a altura total da tela */
            margin: 0;
            padding: 20px 0;
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

        h3 {
            color: #666;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-top: 20px;
        }

        /* ------------------------------------- */
        /* ESTILOS DOS CAMPOS (inputs e labels) */
        /* ------------------------------------- */
        label {
            display: block; /* Garante que o label ocupe sua própria linha */
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
            font-size: 0.9rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%; 
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Garante que padding e borda não aumentem a largura total */
            transition: border-color 0.3s;
        }

        /* Campo de leitura (preenchido automaticamente) */
        input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
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
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #218838; /* Escurece no hover */
        }
    </style>
</head>
<body>

<form action="cadastro.php" method="POST">
    <h2>Cadastrar Novo Usuário</h2>
    
    <!-- DADOS PESSOAIS -->
    <label for="nome">Nome Completo:</label>
    <input type="text" id="nome" name="nome" required placeholder="Seu nome">

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required placeholder="exemplo@email.com">

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required placeholder="Sua senha forte">

    <!-- DADOS DE ENDEREÇO (API VIACEP) -->
    <h3>Endereço (Busca Automática)</h3>
    
    <label for="cep">CEP:</label>
    <!-- onblur chama a função quando sai do campo -->
    <input type="text" id="cep" name="cep" maxlength="9" placeholder="00000-000" required>

    <label for="rua">Rua:</label>
    <input type="text" id="rua" name="rua" readonly>

    <label for="bairro">Bairro:</label>
    <input type="text" id="bairro" name="bairro" readonly>

    <label for="cidade">Cidade:</label>
    <input type="text" id="cidade" name="cidade" readonly>

    <label for="uf">Estado (UF):</label>
    <input type="text" id="uf" name="uf" readonly>

    <button type="submit" name="cadastrar">Cadastrar</button>
</form>

<!-- SCRIPT DA API VIACEP -->
<script>
    // Seleciona o campo CEP
    const cepInput = document.getElementById('cep');

    // Adiciona um evento que dispara quando o usuário sai do campo (blur)
    cepInput.addEventListener('blur', function() {
        // Remove caracteres não numéricos (traços, pontos)
        let cep = this.value.replace(/\D/g, '');

        // Verifica se o CEP tem 8 dígitos
        if (cep.length === 8) {
            // Preenche os campos com "..." enquanto carrega
            document.getElementById('rua').value = "...";
            document.getElementById('bairro').value = "...";
            document.getElementById('cidade').value = "...";
            document.getElementById('uf').value = "...";

            // Faz a requisição para a API ViaCEP
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json()) // Converte a resposta para JSON
                .then(data => {
                    if (!data.erro) {
                        // Se deu certo, preenche os campos
                        document.getElementById('rua').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('cidade').value = data.localidade;
                        document.getElementById('uf').value = data.uf;
                    } else {
                        alert("CEP não encontrado.");
                        limparCamposEndereco();
                    }
                })
                .catch(error => {
                    console.error("Erro na API:", error);
                    alert("Erro ao buscar CEP. Verifique sua conexão.");
                    limparCamposEndereco();
                });
        } else {
            // Se o CEP for inválido (não tem 8 dígitos)
            limparCamposEndereco();
        }
    });

    function limparCamposEndereco() {
        document.getElementById('rua').value = "";
        document.getElementById('bairro').value = "";
        document.getElementById('cidade').value = "";
        document.getElementById('uf').value = "";
    }
</script>

</body>
</html>
