<?php
// Arquivo: processar_voluntario.php

// 1. INCLUSÃO DA CONEXÃO
// Garante que a variável $conn (do seu conexao.php) está disponível
include 'conexao.php'; 

// Verifica se o formulário foi submetido via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. COLETA E SANITIZAÇÃO DOS DADOS
    // Usando $conn para sanitizar
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $disponibilidade = $conn->real_escape_string($_POST['disponibilidade']);
    $mensagem = $conn->real_escape_string($_POST['mensagem']);
    
    // Coleta as áreas de interesse (checkboxes)
    $areas_array = isset($_POST['area']) ? $_POST['area'] : [];
    $areas_interesse = implode(", ", $areas_array); // Transforma o array em string
    
    // Se algum campo obrigatório estiver vazio, pare
    if (empty($nome) || empty($email) || empty($telefone)) {
        die("ERRO: Campos obrigatórios do formulário não preenchidos.");
    }

    // 3. PREPARAÇÃO DA QUERY SQL (STATUS INICIAL: 'Pendente')
    // Atenção: 'pedidos_voluntarios' deve ser o nome exato da sua tabela.
    $sql = "INSERT INTO pedidos_voluntarios (nome, email, telefone, disponibilidade, areas_interesse, mensagem, status) 
            VALUES (?, ?, ?, ?, ?, ?, 'Pendente')";
    
    // 4. EXECUÇÃO DA QUERY
    if ($stmt = $conn->prepare($sql)) {
        // 's' indica que todos os 6 parâmetros são strings
        $stmt->bind_param("ssssss", $nome, $email, $telefone, $disponibilidade, $areas_interesse, $mensagem);
        
        if ($stmt->execute()) {
            // SUCESSO: Redireciona o usuário para uma página de confirmação
            // O usuário não deve ser redirecionado para o menuAdm.php
            header("Location: serVoluntario.php"); 
            exit();
        } else {
            // ERRO NA EXECUÇÃO: Mostrará o erro do MySQL
            die("ERRO AO EXECUTAR INSERÇÃO: " . $stmt->error);
        }
        
        $stmt->close();
    } else {
        // ERRO NA PREPARAÇÃO: Mostra o erro de sintaxe do SQL ou DB
        die("ERRO NA PREPARAÇÃO DA QUERY: " . $conn->error);
    }

    // 5. FECHAMENTO DA CONEXÃO
    $conn->close();

} else {
    // Redireciona se o acesso for direto (sem POST)
    header("Location: seja_voluntario.html"); 
    exit();
}
?>