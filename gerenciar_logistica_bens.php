<?php
// ===========================================
// Arquivo: gerenciar_logistica_bens.php
// Objetivo: Listar e atualizar doações de BENS a partir do banco
// ===========================================

// CONFIG DO BANCO
try {
    $pdo = new PDO("mysql:host=localhost;dbname=sos;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erro ao conectar ao DB: " . $e->getMessage());
}


// ===========================================
// FUNÇÃO PARA GERAR NÚMERO DE REMESSA ÚNICO
// ===========================================
function gerarNumeroRemessa($pdo) {
    do {
        $codigo = "REM" . rand(100000, 999999); // Ex: REM483912
        $sql = "SELECT COUNT(*) FROM doacoes WHERE numero_remessa = :c";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':c' => $codigo]);
        $existe = $stmt->fetchColumn();
    } while ($existe > 0);

    return $codigo;
}


// ===========================================
// PROCESSAR AÇÕES (atualizar status)
// ===========================================
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    // Coletado ➜ gera número de remessa + atualiza status
    if ($action === "coletado") {

        $remessa = gerarNumeroRemessa($pdo);

        $sql = "UPDATE doacoes 
                SET status_logistica = 'Coletado', numero_remessa = :r
                WHERE id = :id AND tipo_doacao = 'Bens'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':r'  => $remessa
        ]);

    } elseif ($action === "recebido") {
        $sql = "UPDATE doacoes SET status_logistica = 'Em Estoque' WHERE id = :id AND tipo_doacao = 'Bens'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

    } elseif ($action === "distribuido") {
        $sql = "UPDATE doacoes SET status_logistica = 'Distribuído' WHERE id = :id AND tipo_doacao = 'Bens'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    header("Location: gerenciar_logistica_bens.php");
    exit;
}


// ===========================================
// BUSCAR DOAÇÕES DE BENS NO BANCO
// ===========================================
$sql = "SELECT * FROM doacoes WHERE tipo_doacao = 'Bens' ORDER BY data_doacao DESC";
$stmt = $pdo->query($sql);
$solicitacoes_bens = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Logística de Bens - SOS Sul</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial; background: #f4f7f6; }
        .header-adm {
            background:#00529B; color:#fff; padding:25px; margin-bottom:20px;
            display:flex; justify-content:space-between; align-items:center;
        }
        .header-adm a {
            color:#FFA500; border:1px solid #FFA500; padding:6px 14px;
            border-radius:6px; text-decoration:none; font-weight:bold;
        }
        .header-adm a:hover { background:#FFA500; color:#00529B; }

        table { width:100%; border-collapse: collapse; background:#fff; }
        th { background:#e0eaff; padding:12px; text-align:left; }
        td { padding:10px; border-bottom:1px solid #eee; }

        .status-badge {
            padding:6px 10px; border-radius:4px; font-size:0.85em; font-weight:bold;
        }
        .A-Coletar { background:#fff3cd; color:#cc9a06; }
        .Coletado { background:#cde2ff; color:#00529B; }
        .Em-Estoque { background:#d4edda; color:#155724; }
        .Distribuído { background:#ffe0e0; color:#a30000; }

        .btn { padding:6px 10px; border-radius:4px; color:#fff; text-decoration:none; }
        .coletado { background:#FFA500; }
        .recebido { background:#28a745; }
        .distribuido { background:#d9534f; }
    </style>
</head>
<body>

<header class="header-adm">
    <h1>Gestão de Logística de Bens - SOS Sul</h1>
    <a href="menuAdm.php">Voltar ao Painel</a>
</header>

<div style="padding:20px;">
    <h2>Doações de Bens</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Doador</th>
            <th>Contato</th>
            <th>Endereço</th>
            <th>Itens</th>
            <th>Data</th>
            <th>Status</th>
            <th>Remessa</th>
            <th>Ações</th>
        </tr>

        <?php if ($solicitacoes_bens): ?>
            <?php foreach ($solicitacoes_bens as $s): ?>
                <tr>
                    <td><?= $s['id'] ?></td>

                    <td><strong><?= htmlspecialchars($s['nome_doador']) ?></strong></td>

                    <td><?= htmlspecialchars($s['contato_telefone']) ?></td>

                    <td><?= nl2br(htmlspecialchars($s['contato_endereco'])) ?></td>

                    <td><?= nl2br(htmlspecialchars($s['detalhes_bens'])) ?></td>

                    <td><?= date('d/m/Y H:i', strtotime($s['data_doacao'])) ?></td>

                    <td>
                        <span class="status-badge <?= str_replace(' ', '-', $s['status_logistica']) ?>">
                            <?= $s['status_logistica'] ?>
                        </span>
                    </td>

                    <td>
                        <?= $s['numero_remessa'] ? $s['numero_remessa'] : "-" ?>
                    </td>

                    <td>
                        <?php if ($s['status_logistica'] === "A Coletar"): ?>
                            <a class="btn coletado" href="?action=coletado&id=<?= $s['id'] ?>">Coletado</a>

                        <?php elseif ($s['status_logistica'] === "Coletado"): ?>
                            <a class="btn recebido" href="?action=recebido&id=<?= $s['id'] ?>">Marcar Recebido</a>

                        <?php elseif ($s['status_logistica'] === "Em Estoque"): ?>
                            <a class="btn distribuido" href="?action=distribuido&id=<?= $s['id'] ?>">Distribuído</a>

                        <?php else: ?>
                            ✔ Finalizado
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="9" style="text-align:center; padding:20px;">
                    Nenhuma doação de bens registrada.
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
