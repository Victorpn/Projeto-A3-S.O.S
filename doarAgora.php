<?php
// =========================================
// Conexão com o banco
// =========================================
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "sos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// =========================================
// PROCESSAMENTO DO FORMULÁRIO
// =========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tipo_doacao = $_POST['tipo_doacao'];
    $nome = !empty($_POST['nome']) ? $_POST['nome'] : "Anonimo";
    $data_doacao = date("Y-m-d H:i:s");
    $observacoes = $_POST['observacoes'] ?? null;

    // CAMPOS COMUNS
    $valor_dinheiro = null;
    $tipo_pagamento = null;
    $status_financeiro = null;

    $detalhes_bens = null;
    $contato_telefone = null;
    $contato_endereco = null;
    $status_logistica = null;

    // DOAÇÃO EM DINHEIRO
    if ($tipo_doacao === "Dinheiro") {
        $valor_dinheiro = $_POST['valor'];
        $tipo_pagamento = $_POST['tipo_pagamento'];
        $status_financeiro = "Pendente";
    }

    // DOAÇÃO EM BENS
    if ($tipo_doacao === "Bens") {
        $detalhes_bens   = $_POST['detalhes_bens'];
        $contato_telefone = $_POST['telefone'];
        $contato_endereco = $_POST['endereco'];
        $status_logistica  = "A Coletar";
    }

    // =========================================
    // SALVAR NO BANCO
    // =========================================
    $stmt = $conn->prepare("
        INSERT INTO doacoes (
            tipo_doacao, data_doacao, nome_doador,
            valor_dinheiro, tipo_pagamento, status_financeiro,
            detalhes_bens, contato_telefone, contato_endereco,
            status_logistica, observacoes
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssssssssss",
        $tipo_doacao, $data_doacao, $nome,
        $valor_dinheiro, $tipo_pagamento, $status_financeiro,
        $detalhes_bens, $contato_telefone, $contato_endereco,
        $status_logistica, $observacoes
    );

    if ($stmt->execute()) {
        echo "<h2>Doação registrada com sucesso!</h2>";
        echo "<a href='doarAgora.php'>Voltar</a>";
        exit;
    } else {
        echo "Erro ao salvar: " . $stmt->error;
    }
}
?>

<!-- =========================================
FORMULÁRIO HTML
========================================= -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Doar Agora</title>

    <style>
        <style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: #f2f6ff;
        margin: 0;
        padding: 40px 0;
        display: flex;
        justify-content: center;
    }

    h1 {
        text-align: center;
        color: #003366;
        margin-bottom: 25px;
        font-size: 32px;
        font-weight: 700;
    }

    form {
        background: #ffffff;
        padding: 30px 40px;
        border-radius: 12px;
        width: 420px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    label {
        font-weight: bold;
        color: #003366;
    }

    input[type="text"],
    input[type="number"],
    select,
    textarea {
        width: 100%;
        padding: 10px;
        margin-top: 6px;
        border: 1px solid #b5c7e3;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
        background: #f8faff;
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: #003366;
        background: #ffffff;
        box-shadow: 0 0 5px rgba(0,51,102,0.2);
    }

    button {
        width: 100%;
        background: #003366;
        color: #fff;
        padding: 14px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.2s;
        margin-top: 10px;
    }

    button:hover {
        background: #0055aa;
    }

    .box {
        border: 1px solid #d0d9ea;
        background: #f9fbff;
        padding: 18px;
        border-radius: 10px;
        margin-top: 10px;
        box-shadow: inset 0 0 6px rgba(0,0,0,0.05);
    }

    h3 {
        color: #003366;
        margin-top: 0;
        text-align: center;
    }

    .hidden {
        display: none;
    }
</style>
        
    </style>

    <script>
        function mostrarCampos() {
            let tipo = document.getElementById("tipo_doacao").value;
            document.getElementById("box_dinheiro").style.display = (tipo === "Dinheiro") ? "block" : "none";
            document.getElementById("box_bens").style.display = (tipo === "Bens") ? "block" : "none";
        }
    </script>
</head>

<body>

<h1>Faça Sua Doação</h1>

<form method="POST">
    <label>Seu Nome (opcional):</label><br>
    <input type="text" name="nome" placeholder="Seu nome"><br><br>

    <label>Tipo de Doação:</label><br>
    <select name="tipo_doacao" id="tipo_doacao" onchange="mostrarCampos()" required>
        <option value="">Selecione...</option>
        <option value="Dinheiro">Dinheiro</option>
        <option value="Bens">Bens</option>
    </select><br><br>

    <!-- CAMPOS PARA DOAÇÃO EM DINHEIRO -->
    <div id="box_dinheiro" class="box hidden">
        <h3>Doação em Dinheiro</h3>

        <label>Valor (R$):</label><br>
        <input type="number" step="0.01" name="valor"><br><br>

        <label>Forma de Pagamento:</label><br>
        <select name="tipo_pagamento">
            <option value="PIX">PIX</option>
            <option value="Cartão">Cartão</option>
            <option value="Boleto">Boleto</option>
        </select>
    </div>

    <!-- CAMPOS PARA DOAÇÃO EM BENS -->
    <div id="box_bens" class="box hidden">
        <h3>Doação de Bens</h3>

        <label>Descrição dos Bens:</label><br>
        <textarea name="detalhes_bens" rows="3"></textarea><br><br>

        <label>Telefone para Contato:</label><br>
        <input type="text" name="telefone"><br><br>

        <label>Endereço para Coleta:</label><br>
        <textarea name="endereco" rows="3"></textarea>
    </div>

    <br>

    <label>Observações:</label><br>
    <textarea name="observacoes" rows="3"></textarea><br><br>

    <button type="submit">Enviar Doação</button>

</form>

</body>
</html>
