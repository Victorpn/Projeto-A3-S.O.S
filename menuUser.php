<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Painel - Impacto e Ação</title>
    
    <!-- 1. CSS DO MAPA (Leaflet) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f8f9fa; color: #333; }
        .container { max-width: 900px; margin: auto; padding: 30px; background-color: #fff; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        
        h1 { color: #0d6efd; font-weight: 700; margin-bottom: 10px; }
        h2 { color: #0d6efd; font-size: 1.5rem; margin-bottom: 15px; border-bottom: 2px solid #f0f2f5; padding-bottom: 10px; }
        .lead { color: #6c757d; font-size: 1.1rem; margin-bottom: 30px; }
        
        /* Botões */
        .btn { display: inline-block; font-weight: 600; text-align: center; text-decoration: none; vertical-align: middle; cursor: pointer; border: 1px solid transparent; padding: 0.375rem 0.75rem; font-size: 1rem; border-radius: 0.25rem; transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out; }
        .btn-primary { background-color: #0d6efd; color: white; }
        .btn-primary:hover { background-color: #0b5ed7; }
        .btn-success { background-color: #198754; color: white; padding: 15px 30px; font-size: 1.2rem; border-radius: 8px; }
        .btn-success:hover { background-color: #157347; }

        /* Cards */
        .card { background: #fff; border: 1px solid #dee2e6; border-radius: 8px; padding: 25px; margin-bottom: 25px; transition: transform 0.2s; }
        .card:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        
        .card-donation { background-color: #f1f8f5; border-left: 5px solid #198754; border-top: none; border-right: none; border-bottom: none; }
        .card-voluntario { background-color: #f0f7ff; border-left: 5px solid #0d6efd; border-top: none; border-right: none; border-bottom: none; }
        .card-mapa { background-color: #fff3cd; border-left: 5px solid #ffc107; border-top: none; border-right: none; border-bottom: none; }

        .alert-info { background-color: #cff4fc; color: #055160; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        
        /* Tabela */
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border-bottom: 1px solid #dee2e6; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; color: #495057; }
        
        /* 2. ESTILO DO MAPA */
        #map { 
            height: 400px; /* Aumentei um pouco para ver melhor os detalhes */
            width: 100%; 
            border-radius: 8px; 
            z-index: 1; /* Garante que fique na camada certa */
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Cabeçalho -->
    <h1>👋 Bem-vindo(a), <?php echo isset($user_name) ? $user_name : 'Colaborador'; ?>!</h1>
    <p class="lead">Unidos pela reconstrução de Rio Bonito do Iguaçu.</p>
    
    <hr>
    
    <!-- Seção de Doação -->
    <section id="doacao" class="card card-donation text-center">
        <h2>💖 Apoie Nossa Causa</h2>
        <p>Sua doação garante recursos essenciais (água, comida, lonas) para as famílias atingidas.</p>
        
        <div style="margin: 20px 0;">
            <a href="doarAgora.php" class="btn btn-success">
                ✨ FAZER UMA DOAÇÃO AGORA
            </a>
        </div>
        
        <div>
            <p style="font-size: 0.9rem; color: #666;">Doações imediatas:</p>
            <button class="btn btn-primary" onclick="alert('Redirecionando para doação de R$25...')">R$ 25 (Lona/Abrigo)</button>
            <button class="btn btn-primary" onclick="alert('Redirecionando para doação de R$75...')">R$ 75 (Cesta Básica)</button>
            <button class="btn btn-primary" onclick="alert('Redirecionando para doação de R$150...')">R$ 150 (Material Const.)</button>
        </div>
    </section>

    <!-- NOVA SEÇÃO: MAPA DA CIDADE -->
    <section id="mapa-apoio" class="card card-mapa">
        <h2 style="color: #856404;">📍 Mapa da Situação (Tempo Real)</h2>
        <p>Visualize as áreas afetadas (90% da zona urbana) e pontos logísticos.</p>
        
        <!-- AQUI ONDE O MAPA VAI APARECER -->
        <div id="map"></div>
        
        <div style="margin-top: 15px; font-size: 0.85rem; color: #555;">
            <strong>Legenda:</strong><br>
            🔴 <strong>Zona Vermelha Escura:</strong> Epicentro / Destruição Total (Ventos > 250km/h)<br>
            ⭕ <strong>Zona Vermelha Clara:</strong> Área Urbana Afetada (Destelhamentos/Quedas de Árvore)<br>
            🏢 <strong>Pino Azul:</strong> Base de Comando / Prefeitura<br>
            🚑 <strong>Pino Amarelo:</strong> Rota de Transferência (Laranjeiras do Sul)
        </div>
    </section>

    <!-- Seção Histórico (PHP) -->
    <?php if (isset($user_logged_in) && $user_logged_in): ?>
        <section id="minhas-doacoes" class="card">
            <h2>💸 Seu Histórico de Doações</h2>
            
            <div class="alert-info">
                <strong>Total Doado:</strong> R$ <?php echo number_format($total_donated ?? 0, 2, ',', '.'); ?>
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
                <p>Você ainda não registrou nenhuma doação.</p>
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <!-- Seção Voluntariado -->
    <section id="voluntariado" class="card card-voluntario">
        <h2>🤝 Voluntariado</h2>
        <p>Precisamos de apoio para limpeza e reconstrução.</p>
        
        <a href="serVoluntario.php" class="btn btn-primary">
            QUERO ME INSCREVER
        </a>

        <h3 style="margin-top: 20px; font-size: 1.1rem; color: #0d6efd;">Ações Urgentes:</h3>
        <ul style="color: #555;">
            <li><strong>Mutirão:</strong> Limpeza das ruas centrais.</li>
            <li><strong>Triagem:</strong> Organização de doações no Ginásio.</li>
        </ul>
    </section>

</div>

<!-- 3. SCRIPT DO MAPA (Leaflet) -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

<script>
    // 1. Inicializa o mapa centralizado na Prefeitura/Centro de Rio Bonito
    var map = L.map('map').setView([-25.4915, -52.5265], 14); 

    // 2. Camada visual do OpenStreetMap
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // --- MARCADORES E ÁREAS (Baseado em dados reais do evento) ---

    // ZONA DE IMPACTO GERAL (90% da cidade afetada segundo notícias)
    var zonaGeral = L.circle([-25.4915, -52.5265], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.2,
        radius: 1300 // Cobre quase toda a área urbana
    }).addTo(map);
    zonaGeral.bindPopup("<b>Zona de Impacto Geral</b><br>Área com destelhamentos generalizados e falta de energia.");

    // EPICENTRO / DESTRUIÇÃO SEVERA
    // Focando na área central e arredores onde estruturas colapsaram
    var zonaSevera = L.circle([-25.4940, -52.5290], {
        color: 'darkred',
        fillColor: '#8b0000', // Vermelho sangue
        fillOpacity: 0.6,
        radius: 500
    }).addTo(map);
    zonaSevera.bindPopup("<b>🌪️ Área Crítica (Epicentro)</b><br>Destruição severa de imóveis.<br>Risco máximo.");

    // BASE DE OPERAÇÕES (Prefeitura)
    var markerBase = L.marker([-25.4915, -52.5265]).addTo(map);
    markerBase.bindPopup("<b>🏢 Comando de Operações</b><br>Defesa Civil e Prefeitura.<br>Ponto de Informações.").openPopup();

    // ROTA DE EVACUAÇÃO / SUPORTE MÉDICO
    // Marcador na saída para a rodovia PR-158 em direção a Laranjeiras do Sul
    // (Hospitais de referência para os feridos)
    var iconAmbulancia = L.divIcon({className: 'my-div-icon', html: '🚑', iconSize: [30, 30]});
    var markerRota = L.marker([-25.4820, -52.5180], {icon: iconAmbulancia}).addTo(map); 
    markerRota.bindPopup("<b>Rota de Transferência</b><br>Saída para Laranjeiras do Sul<br>(Hospitais de Retaguarda).");

</script>

</body>
</html>
