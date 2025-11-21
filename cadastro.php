<?php
// 1. Configurações do Banco de Dados
$host = 'localhost';
$dbname = 'sos';
$user = 'root';
$pass = '';

// Nível de acesso padrão
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
        
        // --- DADOS DE ENDEREÇO (NOVOS) ---
        // O operador ?? '' evita erro se o campo vier vazio ou não existir
        $cep = $_POST['cep'] ?? '';
        $rua = $_POST['rua'] ?? '';
        $bairro = $_POST['bairro'] ?? '';
        $cidade = $_POST['cidade'] ?? '';
        $uf = $_POST['uf'] ?? '';

        // 4. Criptografa a Senha
        $senha_criptografada = password_hash($senha_pura, PASSWORD_DEFAULT);

        // 5. Query de Inserção Atualizada (Commit 6)
        // Agora salvamos também cep, rua, bairro, cidade e uf
        $sql = "INSERT INTO usuarios (nome, email, senha, nivel_acesso, cep, rua, bairro, cidade, uf) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        // 6. Executa a Inserção com os 9 parâmetros
        $stmt->execute([
            $nome, 
            $email, 
            $senha_criptografada, 
            $nivel_padrao,
            $cep,
            $rua,
            $bairro,
            $cidade,
            $uf
        ]);

        // Mensagem de Sucesso Bonita
        echo "<div style='text-align:center; padding:15px; background:#d4edda; color:#155724; margin: 20px auto; max-width:500px; border-radius:5px; border: 1px solid #c3e6cb;'>
                <h3>✅ Cadastro Realizado!</h3>
                <p>Usuário <strong>$nome</strong> cadastrado com sucesso.</p>
                <p>Localização salva: <strong>$cidade - $uf</strong></p>
              </div>";

    }
} catch (PDOException $e) {
    // 7. Trata erros (ex: e-mail já existe)
    if ($e->getCode() == 23000) {
        echo "<div style='text-align:center; padding:10px; background:#f8d7da; color:#721c24; margin: 10px auto; max-width:400px; border-radius:5px;'>❌ O e-mail <strong>$email</strong> já está cadastrado.</div>";
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
    <title>Cadastro Solidário</title>
    <style>
        /* Estilos do Formulário */
        body { font-family: 'Arial', sans-serif; background-color: #f4f7f6; display: flex; flex-direction: column; align-items: center; min-height: 100vh; margin: 0; padding: 20px; }
        form { background-color: #ffffff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        h3 { font-size: 14px; color: #666; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-top: 20px; margin-bottom: 15px;}
        label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; font-size: 0.9rem; }
        input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        input[readonly] { background-color: #e9ecef; cursor: not-allowed; }
        button { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 10px;}
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

<form action="cadastro.php" method="POST">
    <h2>Criar Conta</h2>
    
    <label for="nome">Nome Completo</label>
    <input type="text" id="nome" name="nome" required placeholder="Seu nome">

    <label for="email">E-mail</label>
    <input type="email" id="email" name="email" required placeholder="exemplo@email.com">

    <label for="senha">Senha</label>
    <input type="password" id="senha" name="senha" required placeholder="Sua senha">

    <h3>Endereço (Preenchimento Automático)</h3>
    
    <label for="cep">CEP</label>
    <!-- Script busca CEP automaticamente ao sair deste campo -->
    <input type="text" id="cep" name="cep" maxlength="9" placeholder="00000-000" required>

    <label for="rua">Rua</label>
    <input type="text" id="rua" name="rua" readonly>

    <label for="bairro">Bairro</label>
    <input type="text" id="bairro" name="bairro" readonly>

    <label for="cidade">Cidade</label>
    <input type="text" id="cidade" name="cidade" readonly>

    <label for="uf">Estado (UF)</label>
    <input type="text" id="uf" name="uf" readonly>

    <button type="submit" name="cadastrar">Finalizar Cadastro</button>
</form>

<script>
    // Script para buscar o CEP na API ViaCEP
    const cepInput = document.getElementById('cep');

    cepInput.addEventListener('blur', function() {
        let cep = this.value.replace(/\D/g, '');

        if (cep.length === 8) {
            document.getElementById('rua').value = "...";
            
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('rua').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('cidade').value = data.localidade;
                        document.getElementById('uf').value = data.uf;
                    } else {
                        alert("CEP não encontrado.");
                        limparCampos();
                    }
                })
                .catch(() => {
                    alert("Erro ao buscar CEP.");
                    limparCampos();
                });
        }
    });

    function limparCampos() {
        document.getElementById('rua').value = "";
        document.getElementById('bairro').value = "";
        document.getElementById('cidade').value = "";
        document.getElementById('uf').value = "";
    }
</script>

</body>
</html>
