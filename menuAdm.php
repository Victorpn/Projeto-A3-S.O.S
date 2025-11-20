<?php
// ===========================================
// Arquivo: menuAdm.php (Versão Dinâmica)
// ===========================================
session_start(); // Inicia a sessão (necessário para controle de login)
include 'conexao.php'; // ⭐️ Inclui o arquivo de conexão real com o DB

// 1. VERIFICAÇÃO DE LOGIN (EXEMPLO)
// if (!isset($_SESSION['admin_logado'])) {
//     header('Location: login.php');
//     exit();
// }

// 2. Definição de Variáveis PHP
$pagina_titulo = "Painel de Administração - SOS Sul";
$nome_administrador = "Administrador Mestre"; // Mude para o nome do usuário logado: $_SESSION['admin_nome'];

// 3. CONSULTA REAL AO BANCO DE DADOS
// Busca todos os pedidos com status 'Pendente'
$sql = "SELECT id, nome, email, data_envio, areas_interesse 
        FROM pedidos_voluntarios 
        WHERE status = 'Pendente' 
        ORDER BY data_envio DESC";

$resultado = $conn->query($sql); // ⭐️ Mudei de $conexao para $conn
$solicitacoes_colaboradores = [];

if ($resultado && $resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        // Usa 'areas_interesse' como a função pretendida para a exibição no painel
        $solicitacoes_colaboradores[] = [
            'id' => $linha['id'],
            'nome' => htmlspecialchars($linha['nome']),
            'email' => htmlspecialchars($linha['email']),
            'data_solicitacao' => date('d/m/Y', strtotime($linha['data_envio'])),
            'funcao_pretendida' => htmlspecialchars($linha['areas_interesse']) // Usando áreas como resumo
        ];
    }
}
$conn->close(); // Fecha a conexão após buscar os dados

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pagina_titulo; ?></title>
    <link rel="stylesheet" href="styles.css" /> 
    <style>
        /* (Seus estilos CSS aqui...) */
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
        .requests-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .requests-table th, .requests-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .requests-table th {
            background-color: #e0eaff;
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

        .action-button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.3s;
            margin-right: 5px;
            display: inline-block; /* Para estilizar o link/botão corretamente */
        }
        .action-button:hover {
            opacity: 0.8;
        }
        .approve-btn {
            background-color: #28a745; 
            color: white;
        }
        .reject-btn {
            background-color: #dc3545;
            color: white;
        }
        
        .badge {
            background-color: #FFA500;
            color: white;
            padding: 4px 8px;
            border-radius: 50%;
            font-size: 0.8em;
            margin-left: 5px;
        }
        
        /* Estilos para a mensagem de sucesso/erro */
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-weight: bold;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
        
        <?php if (isset($_GET['msg'])): ?>
            <?php 
                $msg_tipo = $_GET['msg'];
                $action_feita = isset($_GET['action']) ? $_GET['action'] : '';
                $msg_texto = '';
                $msg_class = '';

                if ($msg_tipo === 'sucesso') {
                    $msg_class = 'success';
                    $msg_texto = "Pedido de voluntário **atualizado** para status: **{$action_feita}**!";
                } elseif ($msg_tipo === 'erro') {
                    $msg_class = 'error';
                    $msg_texto = "Erro ao processar o pedido. Detalhes: " . (isset($_GET['details']) ? htmlspecialchars($_GET['details']) : 'Erro desconhecido.');
                } elseif ($msg_tipo === 'erro_interno' || $msg_tipo === 'acao_invalida') {
                    $msg_class = 'error';
                    $msg_texto = "Erro interno ou ação inválida.";
                }
            ?>
            <div class="message <?php echo $msg_class; ?>">
                <?php echo $msg_texto; ?>
            </div>
        <?php endif; ?>

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
                    <th>Áreas de Interesse (Resumo)</th>
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
                                <form action="processar_colaborador.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="pedido_id" value="<?php echo $colaborador['id']; ?>">
                                    <input type="hidden" name="acao" value="Aprovado">
                                    <button type="submit" class="action-button approve-btn" 
                                            onclick="return confirm('Tem certeza que deseja APROVAR este voluntário?');">
                                        Aprovar
                                    </button>
                                </form>

                                <form action="processar_colaborador.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="pedido_id" value="<?php echo $colaborador['id']; ?>">
                                    <input type="hidden" name="acao" value="Rejeitado">
                                    <button type="submit" class="action-button reject-btn"
                                            onclick="return confirm('Tem certeza que deseja REJEITAR este voluntário?');">
                                        Rejeitar
                                    </button>
                                </form>
                                
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: #555;">
                            🎉 Nenhuma solicitação de novo colaborador pendente no momento.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
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