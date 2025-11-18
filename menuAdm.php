<?php
// ===========================================
// Arquivo: menuAdm.php
// Objetivo: Painel administrativo para gerenciar novas solicitações de colaboradores
// (Aprovar/Rejeitar) e listar colaboradores existentes.
// ===========================================

// 1. Definição de Variáveis PHP
$pagina_titulo = "Painel de Administração - SOS Sul";
$nome_administrador = "Administrador Mestre"; // Simulação
$colaboradores_pendentes = 5; // Simulação

// 2. Simulação de Dados (Em um sistema real, estes dados viriam de um Banco de Dados)
$solicitacoes_colaboradores = [
    [
        'id' => 101,
        'nome' => 'João Silva',
        'email' => 'joao.silva@exemplo.com',
        'data_solicitacao' => '15/11/2025',
        'funcao_pretendida' => 'Logística de Bens'
    ],
    [
        'id' => 102,
        'nome' => 'Maria Oliveira',
        'email' => 'maria.o@exemplo.com',
        'data_solicitacao' => '14/11/2025',
        'funcao_pretendida' => 'Validação Financeira'
    ],
    [
        'id' => 103,
        'nome' => 'Pedro Santos',
        'email' => 'pedro.santos@exemplo.com',
        'data_solicitacao' => '12/11/2025',
        'funcao_pretendida' => 'Suporte Voluntário'
    ]
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
        .header-adm p {
            font-size: 1em;
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
        
        /* Estilos para a Tabela de Solicitações */
        .requests-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 8px;
            overflow: hidden; /* Garante que o border-radius funcione com as células */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .requests-table th, .requests-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .requests-table th {
            background-color: #e0eaff; /* Azul claro para o cabeçalho */
            color: #00529B;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9em;
        }
        .requests-table tr:last-child td {
            border-bottom: none;
        }
        .requests-table tr:hover {
            background-color: #f9f9f9;
        }

        /* Estilos para os Botões de Ação */
        .action-button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.3s;
            margin-right: 5px;
        }
        .action-button:hover {
            opacity: 0.8;
        }
        .approve-btn {
            background-color: #28a745; /* Verde para Aprovar */
            color: white;
        }
        .reject-btn {
            background-color: #dc3545; /* Vermelho para Rejeitar */
            color: white;
        }
        
        /* Badge para contagem */
        .badge {
            background-color: #FFA500;
            color: white;
            padding: 4px 8px;
            border-radius: 50%;
            font-size: 0.8em;
            margin-left: 5px;
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
        <div>
            <h1><?php echo $pagina_titulo; ?></h1>
            <p>Bem-vindo(a), <?php echo $nome_administrador; ?></p>
        </div>
        <nav>
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main class="main-content">
        
        <h2 class="section-title">
            Solicitações de Novos Colaboradores
            <span class="badge"><?php echo count($solicitacoes_colaboradores); ?> Pendentes</span>
        </h2>
        
        <table class="requests-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Função Pretendida</th>
                    <th>Data da Solicitação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($solicitacoes_colaboradores) > 0): ?>
                    <?php foreach ($solicitacoes_colaboradores as $colaborador): ?>
                        <tr>
                            <td><?php echo $colaborador['id']; ?></td>
                            <td><?php echo $colaborador['nome']; ?></td>
                            <td><?php echo $colaborador['email']; ?></td>
                            <td><?php echo $colaborador['funcao_pretendida']; ?></td>
                            <td><?php echo $colaborador['data_solicitacao']; ?></td>
                            <td>
                                <!-- Os links abaixo enviariam o ID para um script de processamento no backend -->
                                <a href="processar_colaborador.php?id=<?php echo $colaborador['id']; ?>&action=approve" class="action-button approve-btn">Aprovar</a>
                                <a href="processar_colaborador.php?id=<?php echo $colaborador['id']; ?>&action=reject" class="action-button reject-btn">Rejeitar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">
                            Nenhuma solicitação de novo colaborador pendente no momento.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Outras Seções Administrativas (Ex: Doações de Bens Pendentes, Relatórios, etc.) -->
        <h2 class="section-title">Outras Ações Administrativas</h2>
        <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <ul>
                <li><a href="gerenciar_doacoes.php" style="color:#00529B;">Gerenciar Doações Financeiras</a></li>
                <li><a href="gerenciar_logistica_bens.php" style="color:#00529B;">Gerenciar Solicitações de Doação de Bens</a></li>
                <li><a href="relatorios.php" style="color:#00529B;">Visualizar Relatórios e Métricas</a></li>
            </ul>
        </div>
        
    </main>

    <footer>
        <p>&copy; 2025 SOS Sul. Painel Administrativo.</p>
    </footer>
</body>
</html>