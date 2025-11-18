<?php
// ===========================================
// Arquivo: gerenciar_logistica_bens.php
// Objetivo: Painel administrativo para gerenciar a logística de doações de bens (roupas, comida, etc.)
// ===========================================

// 1. Definição de Variáveis PHP
$pagina_titulo = "Gestão de Logística de Bens - SOS Sul";

// 2. Simulação de Dados (Em um sistema real, estes dados viriam de um Banco de Dados)
$solicitacoes_bens = [
    [
        'id' => 2001,
        'nome_doador' => 'Felipe Souza',
        'telefone' => '(51) 98765-4321',
        'endereco' => 'Rua das Flores, 100, Centro, Porto Alegre',
        'itens' => [
            'alimentos' => '10kg de arroz, 5 pacotes de feijão, 1 caixa de leite',
            'higiene' => '2 kits de shampoo e sabonete'
        ],
        'obs_gerais' => 'Disponível para coleta após as 18h.',
        'data_solicitacao' => '15/11/2025 15:40',
        'status' => 'Pendente de Agendamento'
    ],
    [
        'id' => 2002,
        'nome_doador' => 'Gabriela Costa',
        'telefone' => '(54) 99123-4567',
        'endereco' => 'Av. Brasil, 45, Ap. 201, Caxias do Sul',
        'itens' => [
            'roupas' => '3 sacos grandes de roupas de bebê e cobertores em ótimo estado'
        ],
        'obs_gerais' => 'Deixarei com o porteiro.',
        'data_solicitacao' => '14/11/2025 09:20',
        'status' => 'Coleta Agendada (Aguardando Retirada)'
    ],
    [
        'id' => 2003,
        'nome_doador' => 'Henrique Lima',
        'telefone' => '(53) 98888-7777',
        'endereco' => 'Av. Principal, 500, Pelotas',
        'itens' => [
            'moveis' => '1 geladeira funcionando, 1 sofá de 3 lugares',
            'outros' => 'Livros didáticos'
        ],
        'obs_gerais' => '-',
        'data_solicitacao' => '12/11/2025 21:05',
        'status' => 'Pendente de Agendamento'
    ]
];

// Mapeamento dos valores dos itens para nomes amigáveis (usados na tabela)
$item_map = [
    'alimentos' => 'Alimentos',
    'roupas' => 'Roupas/Cobertores',
    'higiene' => 'Higiene/Limpeza',
    'moveis' => 'Móveis/Eletrodomésticos',
    'outros' => 'Outros Itens'
];

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
            background-color: #00529B; 
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
        
        /* Tabela de Logística */
        .logistica-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 8px;
            overflow: hidden; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .logistica-table th, .logistica-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .logistica-table th {
            background-color: #e0eaff;
            color: #00529B;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9em;
        }
        .logistica-table tr:last-child td {
            border-bottom: none;
        }
        .logistica-table tr:hover {
            background-color: #f9f9f9;
        }

        /* Estilos para Badges de Status */
        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.8em;
            display: inline-block;
        }
        .status-Pendente-de-Agendamento {
            background-color: #fff3cd;
            color: #ffc107;
        }
        .status-Coleta-Agendada-Aguardando-Retirada {
            background-color: #e0eaff;
            color: #00529B;
        }
        
        /* Estilos para Botões de Ação de Logística */
        .action-btn-group button {
            padding: 8px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.9em;
            transition: opacity 0.3s;
        }
        .action-btn-group button:hover {
            opacity: 0.8;
        }
        .schedule-btn {
            background-color: #FFA500; /* Laranja para Agendar */
            color: white;
        }
        .received-btn {
            background-color: #28a745; /* Verde para Recebido */
            color: white;
        }
        .contact-info {
            font-size: 0.9em;
            color: #555;
            margin-top: 5px;
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
        
        <h2 class="section-title">
            Solicitações de Doação de Bens Pendentes 
            <span style="font-size: 0.7em; color: #555;">(Itens Físicos)</span>
        </h2>
        
        <table class="logistica-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Doador/Contato</th>
                    <th>Endereço para Coleta</th>
                    <th>Itens Detalhados</th>
                    <th>Data Solicitação</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($solicitacoes_bens) > 0): ?>
                    <?php foreach ($solicitacoes_bens as $solicitacao): ?>
                        <tr>
                            <td><?php echo $solicitacao['id']; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($solicitacao['nome_doador']); ?></strong>
                                <div class="contact-info">Tel: <?php echo htmlspecialchars($solicitacao['telefone']); ?></div>
                            </td>
                            <td><?php echo htmlspecialchars($solicitacao['endereco']); ?></td>
                            <td>
                                <?php
                                    foreach ($solicitacao['itens'] as $tipo => $detalhe) {
                                        // Usa o item_map para exibir o nome amigável do tipo
                                        $nome_amigavel = $item_map[$tipo] ?? ucfirst($tipo);
                                        echo "<strong>{$nome_amigavel}:</strong> " . htmlspecialchars($detalhe) . "<br>";
                                    }
                                    if ($solicitacao['obs_gerais'] && $solicitacao['obs_gerais'] !== '-') {
                                        echo "<br><small style='color: #888;'>Obs: " . htmlspecialchars($solicitacao['obs_gerais']) . "</small>";
                                    }
                                ?>
                            </td>
                            <td><?php echo $solicitacao['data_solicitacao']; ?></td>
                            <td>
                                <?php 
                                    $status_class = str_replace([' ', '(', ')'], '-', $solicitacao['status']);
                                ?>
                                <span class="status-badge status-<?php echo $status_class; ?>">
                                    <?php echo $solicitacao['status']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <?php if ($solicitacao['status'] === 'Pendente de Agendamento'): ?>
                                        <!-- Simulando a ação de agendar (poderia abrir um modal) -->
                                        <button class="schedule-btn" onclick="alert('Agendando coleta para ID <?php echo $solicitacao['id']; ?>. Detalhes de contato: <?php echo $solicitacao['telefone']; ?>')">
                                            Agendar Coleta
                                        </button>
                                    <?php else: ?>
                                        <!-- Simulando a ação de confirmar recebimento -->
                                        <button class="received-btn" onclick="alert('Confirmando recebimento dos itens da ID <?php echo $solicitacao['id']; ?>')">
                                            Recebido
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">
                            Nenhuma solicitação de doação de bens pendente no momento.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
    </main>

    <footer>
        <p>&copy; 2025 SOS Sul. Painel Administrativo de Logística.</p>
    </footer>
</body>
</html>