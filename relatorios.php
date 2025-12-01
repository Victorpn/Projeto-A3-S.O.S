<?php
// ==========================================================
// CONEXÃO COM O BANCO DE DADOS
// ==========================================================
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "sos";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

// ==========================================================
// TOTAL ARRECADADO REAL (Somando valores da tabela)
// ==========================================================

$stmt = $pdo->query("
    SELECT SUM(valor_dinheiro) AS total 
    FROM doacoes 
    WHERE tipo_doacao = 'Dinheiro' 
      AND status_financeiro = 'Confirmado'
");

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$monetary_total_donations = $result['total'] ?? 0;

// ==========================================================
// OUTROS DADOS FIXOS (SE QUISER DEIXO DINÂMICO DEPOIS)
// ==========================================================
$monetary_conversion_rate = 12.5;
$monetary_abandonment_rate = 22.1;
$monetary_best_channel = "E-mail Marketing";

$physical_intent_rate = 35.8;
$physical_collection_visits = 4120;
$physical_exit_rules = 15.5;
$physical_most_needed = "Kits de Higiene";

// ==========================================================
// FUNÇÕES AUXILIARES
// ==========================================================
function format_currency($amount) {
    return 'R$ ' . number_format($amount, 2, ',', '.');
}

function format_percent($rate) {
    return number_format($rate, 1, ',', '.') . ' %';
}

function get_status_color($rate, $is_good_low = false) {
    if ($is_good_low) {
        if ($rate < 20) return 'color: #28a745;';
        if ($rate >= 20 && $rate < 30) return 'color: #ffc107;';
        return 'color: #dc3545;';
    } else {
        if ($rate > 10) return 'color: #28a745;';
        if ($rate >= 5 && $rate <= 10) return 'color: #ffc107;';
        return 'color: #dc3545;';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios de Impacto de Ajuda a Desastres</title>

    <!-- ESTILOS (EXATAMENTE COMO SEU CÓDIGO ORIGINAL) -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f7f9;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        h2 {
            color: #343a40;
            margin-top: 40px;
            border-left: 5px solid #ffc107;
            padding-left: 10px;
        }
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .metric-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .metric-card h3 {
            margin-top: 0;
            font-size: 1.1em;
            color: #6c757d;
        }
        .metric-card .value {
            font-size: 2.2em;
            font-weight: bold;
            margin: 10px 0 0 0;
        }
        .metric-card p {
            font-size: 0.9em;
            color: #6c757d;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #e9ecef;
        }
        .recommendation {
            background-color: #e2f0ff;
            border-left: 5px solid #007bff;
            padding: 15px;
            margin-top: 30px;
            border-radius: 4px;
        }
        .recommendation h3 {
            color: #007bff;
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Dashboard de Relatórios de Impacto</h1>

    <h2>💰 Desempenho de Doações Monetárias (Conversão)</h2>

    <div class="metric-grid">

        <div class="metric-card">
            <h3>Taxa de Conversão</h3>
            <p class="value" style="<?php echo get_status_color($monetary_conversion_rate); ?>">
                <?php echo format_percent($monetary_conversion_rate); ?>
            </p>
            <p>Percentual de visitantes que concluíram a doação.</p>
        </div>

        <div class="metric-card">
            <h3>Total Arrecadado</h3>
            <p class="value">
                <?php echo format_currency($monetary_total_donations); ?>
            </p>
            <p>Valor total de doações confirmadas.</p>
        </div>

        <div class="metric-card">
            <h3>Abandono do Formulário</h3>
            <p class="value" style="<?php echo get_status_color($monetary_abandonment_rate, true); ?>">
                <?php echo format_percent($monetary_abandonment_rate); ?>
            </p>
            <p>Taxa de usuários que iniciaram, mas não finalizaram a doação.</p>
        </div>

        <div class="metric-card">
            <h3>Canal de Maior Conversão</h3>
            <p class="value" style="color: #6c757d; font-size: 1.8em;">
                <?php echo $monetary_best_channel; ?>
            </p>
            <p>Fonte de tráfego que gerou as melhores conversões.</p>
        </div>

    </div>

    <div class="recommendation">
        <h3>Recomendação de Ação Imediata (Monetário)</h3>
        <p>A taxa de abandono do formulário é de <strong><?php echo format_percent($monetary_abandonment_rate); ?></strong>.
        Recomendamos analisar o formulário de pagamento para <strong>remover campos desnecessários</strong> ou otimizar a velocidade de carregamento para aumentar a conversão.</p>
    </div>


    <h2>📦 Desempenho de Doações Físicas (Logística)</h2>

    <div class="metric-grid">

        <div class="metric-card">
            <h3>Taxa de Intenção</h3>
            <p class="value" style="<?php echo get_status_color($physical_intent_rate); ?>">
                <?php echo format_percent($physical_intent_rate); ?>
            </p>
            <p>Percentual de visitantes que indicaram intenção de doar bens.</p>
        </div>

        <div class="metric-card">
            <h3>Visualizações de Endereços</h3>
            <p class="value">
                <?php echo number_format($physical_collection_visits, 0, ',', '.'); ?>
            </p>
            <p>Total de cliques na lista de pontos de coleta.</p>
        </div>

        <div class="metric-card">
            <h3>Taxa de Saída (Regras)</h3>
            <p class="value" style="<?php echo get_status_color($physical_exit_rules, true); ?>">
                <?php echo format_percent($physical_exit_rules); ?>
            </p>
            <p>Saída após visualizar regras de doação.</p>
        </div>

        <div class="metric-card">
            <h3>Foco Logístico</h3>
            <p class="value" style="color: #dc3545; font-size: 1.8em;">
                <?php echo $physical_most_needed; ?>
            </p>
            <p>Item mais necessário no momento.</p>
        </div>

    </div>

    <div class="recommendation">
        <h3>Recomendação de Ação Imediata (Físico)</h3>
        <p>O item <strong><?php echo $physical_most_needed; ?></strong> está em maior demanda.  
        Destaque-o na página inicial e prepare os pontos de coleta para maior volume.</p>
    </div>

</div>

</body>
</html>
