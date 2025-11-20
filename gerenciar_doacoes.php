<?php
session_start();

/* ============================================================
   CONEXÃO COM O BANCO
============================================================ */
try {
    $pdo = new PDO("mysql:host=localhost;dbname=sos;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage());
}

/* ============================================================
   FUNÇÃO FORMATO DE MOEDA
============================================================ */
function formatar_moeda($valor) {
    return "R$ " . number_format($valor, 2, ',', '.');
}

/* ============================================================
   BUSCAR DOAÇÕES EM DINHEIRO
============================================================ */
$sql = "SELECT id, valor_dinheiro, nome_doador, tipo_pagamento, data_doacao, status_financeiro 
        FROM doacoes 
        WHERE tipo_doacao = 'Dinheiro'
        ORDER BY data_doacao DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$doacoes_recentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ============================================================
   TOTAL ARRECADADO
============================================================ */
$sqlTotal = "SELECT SUM(valor_dinheiro) AS total FROM doacoes WHERE tipo_doacao = 'Dinheiro' AND status_financeiro = 'Confirmado'";
$stmtTotal = $pdo->prepare($sqlTotal);
$stmtTotal->execute();
$total_arrecadado = $stmtTotal->fetchColumn() ?? 0;

/* ============================================================
   NOTIFICAÇÃO CASO ALGUMA DOAÇÃO NOVA TENHA SIDO FEITA
============================================================ */
$mensagem_notificacao_adm = "";
if (isset($_SESSION['mensagem_admin_financeiro'])) {
    $mensagem_notificacao_adm = $_SESSION['mensagem_admin_financeiro'];
    unset($_SESSION['mensagem_admin_financeiro']);
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Doações Financeiras</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial; background: #f4f7f6; }
        .header-adm { background: #00529B; color: white; padding: 25px; display:flex; justify-content:space-between; }
        table { width:100%; background:white; border-radius:8px; overflow:hidden; }
        th { background:#e0eaff; padding:12px; text-align:left; }
        td { padding:12px; border-bottom:1px solid #eee; }
        .status-Confirmado { background:#d5ffd5; padding:5px 10px; border-radius:5px; color:#0f7c0f; }
        .status-Pendente { background:#fff5c2; padding:5px 10px; border-radius:5px; color:#c99700; }
    </style>
</head>
<body>

<header class="header-adm">
    <h1>Gestão de Doações Financeiras</h1>
    <nav>
        <a href="doarAgora.php" style="color:white;">Voltar</a>
    </nav>
</header>

<main style="max-width:1100px; margin:0 auto;">

    <?php if ($mensagem_notificacao_adm): ?>
        <div style="background:#e6d4ff; padding:15px; border-radius:6px; margin-top:15px; text-align:center;">
            <?= $mensagem_notificacao_adm ?>
        </div>
    <?php endif; ?>

    <h2 style="color:#00529B; margin-top:40px;">Total Arrecadado</h2>
    <div style="background:white; padding:20px; border-radius:8px; font-size:22px; margin-bottom:30px;">
        <strong><?= formatar_moeda($total_arrecadado) ?></strong>
    </div>

    <h2 style="color:#00529B;">Últimas Doações</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Valor</th>
                <th>Doador</th>
                <th>Método</th>
                <th>Data</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($doacoes_recentes) > 0): ?>
                <?php foreach ($doacoes_recentes as $d): ?>
                <tr>
                    <td><?= $d['id'] ?></td>
                    <td><strong><?= formatar_moeda($d['valor_dinheiro']) ?></strong></td>
                    <td><?= htmlspecialchars($d['nome_doador']) ?></td>
                    <td><?= strtoupper($d['tipo_pagamento']) ?></td>
                    <td><?= date("d/m/Y H:i", strtotime($d['data_doacao'])) ?></td>
                    <td>
                        <span class="status-<?= $d['status_financeiro'] ?>">
                            <?= $d['status_financeiro'] ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">Nenhuma doação registrada.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</main>

</body>
</html>
