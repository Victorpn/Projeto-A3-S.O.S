<?php
// ===========================================
// Arquivo: gerenciar_doacoes.php
// Objetivo: Painel administrativo para gerenciar doações financeiras
// ===========================================

// 1. Definição de Variáveis PHP
$pagina_titulo = "Gestão de Doações Financeiras - SOS Sul";
$total_arrecadado_simulado = 125430.50;

// 2. Simulação de Dados (Em um sistema real, estes dados viriam de um Banco de Dados)
$doacoes_recentes = [
    [
        'id' => 5001,
        'valor' => 50.00,
        'nome_doador' => 'Ana C.',
        'email_doador' => 'anac@email.com',
        'tipo_pagamento' => 'PIX',
        'data_doacao' => '15/11/2025 14:35',
        'status' => 'Confirmada'
    ],
    [
        'id' => 5002,
        'valor' => 100.00,
        'nome_doador' => 'Bruno M.',
        'email_doador' => 'brunom@servico.br',
        'tipo_pagamento' => 'Cartão de Crédito',
        'data_doacao' => '15/11/2025 10:10',
        'status' => 'Confirmada'
    ],
    [
        'id' => 5003,
        'valor' => 25.50,
        'nome_doador' => 'Carla P.',
        'email_doador' => 'carlap@provedor.com',
        'tipo_pagamento' => 'Boleto Bancário',
        'data_doacao' => '14/11/2025 18:00',
        'status' => 'Pendente'
    ],
    [
        'id' => 5004,
        'valor' => 500.00,
        'nome_doador' => 'Doação Anônima',
        'email_doador' => '-',
        'tipo_pagamento' => 'PIX',
        'data_doacao' => '14/11/2025 11:22',
        'status' => 'Confirmada'
    ],
    [
        'id' => 5005,
        'valor' => 150.00,
        'nome_doador' => 'Empresa X',
        'email_doador' => 'contato@empresaX.com.br',
        'tipo_pagamento' => 'Cartão de Crédito',
        'data_doacao' => '13/11/2025 09:40',
        'status' => 'Confirmada'
    ]
];

/**
 * Função utilitária para formatar valores em Reais (BRL)
 * Em um sistema real, usaria-se a classe Intl.
 */
function formatar_moeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pagina_titulo; ?></title>
    <!-- Assumindo que 'styles.css' existe -->
    <link rel="stylesheet" href="styles.css" /> 
    <style>
        /* Estilos base reutilizados para consistência */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
            padding-bottom: 50px;
        }
        .header-adm {
            background-color: #00529B; /* Azul Institucional */
            color: white;
            padding: 30px 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-adm h1 {
            font-size: 2em;
            margin: 0;
        }
        .header-adm a {
            color: #FFA500;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 15px;
            border: 1px solid #FFA500;
            border-radius: 6px;
            transition: background-color 0.3s, color 0.3s;
        }
        .header-adm a:hover {
            background-color: #FFA500;
            color: #00529B;
        }
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .section-title {
            color: #00529B;
            border-bottom: 3px solid #FFA500;
            padding-bottom: 10px;
            margin-top: 40px;
            margin-bottom: 25px;
            font-size: 1.8em;
        }
        
        /* Dashboard Cards */
        .summary-cards {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            flex: 1;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            text-align: center;
        }
        .card h3 {
            margin-top: 0;
            color: #00529B;
            font-size: 1.1em;
        }
        .card .value {
            font-size: 2.5em;
            font-weight: bold;
            color: #28a745; /* Verde para sucesso/arrecadação */
        }
        .card.pending .value {
            color: #FFA500; /* Laranja para pendente */
        }

        /* Tabela de Doações */
        .doacoes-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 8px;
            overflow: hidden; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .doacoes-table th, .doacoes-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .doacoes-table th {
            background-color: #e0eaff;
            color: #00529B;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9em;
        }
        .doacoes-table tr:last-child td {
            border-bottom: none;
        }
        .doacoes-table tr:hover {
            background-color: #f9f9f9;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.8em;
        }
        .status-Confirmada {
            background-color: #e6ffed;
            color: #28a745;
        }
        .status-Pendente {
            background-color: #fff3cd;
            color: #ffc107;
        }

        footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            color: #888;
        }
    </style>
</head>
<body>
    <header class="header-adm">
        <h1><?php echo $pagina_titulo; ?></h1>
        <nav>
            <a href="menuAdm.php">Voltar ao Painel</a>
        </nav>
    </header>

    <main class="main-content">
        
        <div class="summary-cards">
            <div class="card">
                <h3>Total Arrecadado (Simulado)</h3>
                <div class="value"><?php echo formatar_moeda($total_arrecadado_simulado); ?></div>
                <p style="font-size: 0.9em; color: #888;">Última atualização: Hoje, 15:00</p>
            </div>
            <div class="card pending">
                <h3>Doações Pendentes</h3>
                <?php
                    $pendentes = array_filter($doacoes_recentes, function($d) { return $d['status'] === 'Pendente'; });
                ?>
                <div class="value"><?php echo count($pendentes); ?></div>
                <p style="font-size: 0.9em; color: #888;">Aguardando compensação (Boleto, etc.)</p>
            </div>
        </div>

        <h2 class="section-title">Últimas Doações Recebidas</h2>
        
        <table class="doacoes-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Valor</th>
                    <th>Doador/E-mail</th>
                    <th>Método</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($doacoes_recentes) > 0): ?>
                    <?php foreach ($doacoes_recentes as $doacao): ?>
                        <tr>
                            <td><?php echo $doacao['id']; ?></td>
                            <td><strong><?php echo formatar_moeda($doacao['valor']); ?></strong></td>
                            <td>
                                <?php echo htmlspecialchars($doacao['nome_doador']); ?>
                                <br><small style="color:#888;"><?php echo htmlspecialchars($doacao['email_doador']); ?></small>
                            </td>
                            <td><?php echo $doacao['tipo_pagamento']; ?></td>
                            <td><?php echo $doacao['data_doacao']; ?></td>
                            <td>
                                <span class="status-badge status-<?php echo str_replace(' ', '', $doacao['status']); ?>">
                                    <?php echo $doacao['status']; ?>
                                </span>
                            </td>
                            <td>
                                <!-- Ações (Simulação) -->
                                <a href="detalhes_doacao.php?id=<?php echo $doacao['id']; ?>" style="color: #00529B; text-decoration: none;">Ver Detalhes</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">
                            Nenhuma doação financeira registrada recentemente.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
    </main>

    <footer>
        <p>&copy; 2025 SOS Sul. Painel Administrativo.</p>
    </footer>
</body>
</html>