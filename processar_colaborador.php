<?php
// Arquivo: processar_colaborador.php
session_start();
include 'conexao.php'; // Inclui a conexão com o DB, usando a variável $conn

// 1. Verifica se os dados necessários foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pedido_id'], $_POST['acao'])) {
    
    // Coleta e sanitiza os dados
    $pedido_id = (int)$_POST['pedido_id'];
    $acao = $_POST['acao']; // Deve ser 'Aprovado' ou 'Rejeitado'

    // 2. Valida a ação
    if ($acao === 'Aprovado' || $acao === 'Rejeitado') {
        
        // 3. Prepara a query SQL para atualização (usando $conn)
        $sql_update = "UPDATE pedidos_voluntarios SET status = ? WHERE id = ?";
        
        if ($stmt = $conn->prepare($sql_update)) {
            $stmt->bind_param("si", $acao, $pedido_id);
            
            if ($stmt->execute()) {
                // Sucesso: Redireciona de volta para o painel com mensagem de sucesso
                $stmt->close();
                $conn->close();
                header("Location: menuAdm.php?msg=sucesso&action=" . $acao);
                exit();
            } else {
                // Erro: Redireciona com erro
                $stmt->close();
                $conn->close();
                header("Location: menuAdm.php?msg=erro&details=" . urlencode("Falha ao executar a atualização: " . $stmt->error));
                exit();
            }
        } else {
            // Erro na preparação
            $conn->close();
            header("Location: menuAdm.php?msg=erro_interno&details=" . urlencode("Falha na preparação da query."));
            exit();
        }
    }
} 

// Se o script não encontrou a ação válida ou não foi POST
header("Location: menuAdm.php");
exit();
?>