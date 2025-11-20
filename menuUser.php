<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Painel - Impacto e Ação</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f8f9fa; }
        .container { max-width: 900px; margin: auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #007bff; }
        .btn-primary { background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-success { background-color: #28a745; color: white; border: none; padding: 15px 30px; font-size: 1.2rem; border-radius: 8px; cursor: pointer; text-decoration: none; display: inline-block; }
        .card { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .card-donation { background-color: #e9f7ef; border-left: 5px solid #28a745; }
        .card-voluntario { background-color: #e9f4ff; border-left: 5px solid #007bff; }
        .alert-info { background-color: #d1ecf1; color: #0c5460; padding: 10px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<div class="container">

    <h1>👋 Bem-vindo(a) ao Seu Painel, <?php echo $user_name; ?>!</h1>
    <p class="lead">Obrigado por fazer parte da nossa missão. Sua ação faz a diferença.</p>
    
    <hr>
    
    <section id="doacao" class="card card-donation text-center">
        <h2>💖 Apoie Nossa Causa</h2>
        <p>Sua doação garante recursos essenciais para continuar nosso trabalho. Escolha como quer ajudar!</p>
        
        <a href="doarAgora.php" class="btn btn-success">
            ✨ DOAR AGORA!
        </a>
        
        <div style="margin-top: 15px;">
            <p>Ou escolha um valor que representa um impacto:</p>
            <button class="btn btn-primary" onclick="alert('Redirecionando para doação de R$25...')">R$ 25 (Um Kit)</button>
            <button class="btn btn-primary" onclick="alert('Redirecionando para doação de R$75...')">R$ 75 (Um dia)</button>
            <button class="btn btn-primary" onclick="alert('Redirecionando para doação de R$150...')">R$ 150 (Uma Semana)</button>
        </div>
    </section>

    <?php if ($user_logged_in): ?>
        <section id="minhas-doacoes" class="card">
            <h2>💸 Seu Histórico de Doações</h2>
            
            <div class="alert-info">
                <strong>Total Doado:</strong> R$ <?php echo number_format($total_donated, 2, ',', '.'); ?>
            </div>
            
            <?php if (!empty($user_donations)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Forma</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user_donations as $donation): ?>
                            <tr>
                                <td><?php echo $donation['data']; ?></td>
                                <td>R$ <?php echo number_format($donation['valor'], 2, ',', '.'); ?></td>
                                <td><?php echo $donation['forma']; ?></td>
                                <td><span style="color: green; font-weight: bold;"><?php echo $donation['status']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Você ainda não registrou nenhuma doação. Sua primeira contribuição será listada aqui!</p>
            <?php endif; ?>
            <p style="margin-top: 15px;">* Caso falte alguma doação, entre em contato.</p>
        </section>
    <?php endif; ?>

    <section id="voluntariado" class="card card-voluntario">
        <h2>🤝 Seja um Voluntário</h2>
        <p>Invista seu tempo e talento para criar um impacto direto e transformador na vida de quem mais precisa.</p>
        
        <a href="serVoluntario.php" class="btn btn-primary">
            QUERO SER VOLUNTÁRIO
        </a>

        <h3 style="margin-top: 20px;">Próximas Oportunidades:</h3>
        <ul>
            <li>**25/Nov - 14h:** Ação de Limpeza Comunitária (5 vagas)</li>
            <li>**01/Dez - 9h:** Organização de Kits de Higiene (10 vagas)</li>
            <li>**Online:** Suporte em Mídias Sociais (2 vagas - Flexível)</li>
        </ul>
    </section>

    <section id="transparencia" class="card">
        <h2>📊 Transparência e Impacto</h2>
        <p>Acreditamos na prestação de contas. Veja onde seus recursos e seu tempo estão sendo aplicados:</p>
        
        <ul>
            <li>✅ **Relatório Financeiro Anual (2024):** <a href="link_pdf_relatorio.pdf">Baixar PDF</a></li>
            <li>✅ **Metas do Mês:** Faltam R$ 3.500 para garantir a distribuição de 100 cestas básicas.</li>
            <li>✅ **Impacto:** Já levamos esperança para mais de **800** pessoas este ano.</li>
        </ul>
    </section>

</div>

</body>
</html>