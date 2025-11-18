<?php
// ===========================================
// Arquivo: doarAgora.php
// Objetivo: Mostrar o formulário de doação (dinheiro ou bens)
// ===========================================

// 1. Definição de Variáveis PHP
$pagina_titulo = "Faça Sua Doação - SOS Sul";
$mensagem_de_apoio = "Cada contribuição ajuda na reconstrução do Rio Grande do Sul. Escolha como você deseja apoiar!";

// Definição dos tipos de bens e seus rótulos para geração dinâmica do formulário
$tipos_de_bens = [
    'alimentos' => 'Alimentos Não Perecíveis',
    'roupas' => 'Roupas, Calçados e Cobertores',
    'higiene' => 'Itens de Higiene e Limpeza',
    'moveis' => 'Móveis e Eletrodomésticos',
    'outros' => 'Outros (Ex: Medicamentos, Voluntariado, Livros, etc.)'
];

// 2. Lógica PHP (Se Necessária)
// Aqui ficaria qualquer lógica de backend para carregar dados. 

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pagina_titulo; ?></title>
    <!-- Assumindo que 'styles.css' existe, mas adicionando estilos inline para garantir a funcionalidade -->
    <link rel="stylesheet" href="styles.css" /> 
    <style>
        /* Estilos base (Mantenha o CSS original com melhorias) */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
        }
        .hero {
            background-color: #00529B; /* Azul Institucional */
            color: white;
            padding: 40px 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .hero h1 {
            font-size: 2.5em;
            margin: 0;
        }
        .hero p {
            font-size: 1.1em;
            margin-top: 10px;
        }
        .content {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .donation-form-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        .donation-form-container label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #00529B;
        }
        .donation-form-container input:not([type="radio"]):not([type="checkbox"]),
        .donation-form-container select,
        .donation-form-container textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box; 
            transition: border-color 0.3s;
        }
        .donation-form-container input:focus,
        .donation-form-container select:focus,
        .donation-form-container textarea:focus {
            border-color: #FFA500; /* Laranja de destaque */
            outline: none;
        }
        .button {
            margin-top: 25px;
            padding: 12px 20px;
            width: 100%;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .primary {
            background-color: #FFA500; /* Botão de ação primária */
            color: white;
        }
        .primary:hover {
            background-color: #ff9900;
        }
        
        /* Estilos para o seletor de tipo de doação */
        .donation-type-selector {
            text-align: center;
            margin-bottom: 30px;
        }
        .donation-type-selector input[type="radio"] {
            display: none;
        }
        .donation-type-selector label {
            display: inline-block;
            padding: 15px 30px;
            margin: 0 10px;
            background-color: #e0e0e0;
            color: #333;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .donation-type-selector input[type="radio"]:checked + label {
            background-color: #00529B;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 82, 155, 0.3);
        }
        
        /* Ocultar forms por padrão */
        #monetaryForm, #goodsForm {
            display: none;
        }

        /* Estilos para campos de contato em Doação de Bens */
        .contact-group {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px dashed #ccc;
        }

        /* Estilos para o novo grupo de Checkboxes */
        .checkbox-group-container {
            margin-top: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #f9f9f9;
        }
        .donation-item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            gap: 10px;
        }
        .checkbox-control {
            flex-basis: 50%; /* Checkbox e label ocupam metade da largura */
        }
        .item-details {
            flex-basis: 50%; /* Campo de detalhes ocupa a outra metade */
        }
        .item-details input {
            width: 100%;
            padding: 8px;
            margin: 0;
            font-size: 0.9em;
        }
        .checkbox-group-container label.checkbox-label {
            display: inline; /* Faz com que o texto fique na mesma linha da checkbox */
            font-weight: normal;
            color: #333;
            margin-left: 8px; 
            cursor: pointer;
            /* Remove a margin-top desnecessária da regra genérica */
            margin-top: 0; 
        }
        .checkbox-group-container input[type="checkbox"] {
            width: auto;
            margin-top: 0;
            vertical-align: middle;
            transform: scale(1.2);
        }
        /* Classe para esconder e habilitar/desabilitar o campo */
        .hidden {
            display: none;
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
    <header class="hero">
        <h1><?php echo $pagina_titulo; ?></h1>
        <p><?php echo $mensagem_de_apoio; ?></p>
    </header>

    <main class="content">
        <div class="donation-type-selector">
            <!-- Seletor de Tipo de Doação -->
            <input type="radio" id="selectMonetary" name="donationType" value="monetary" checked>
            <label for="selectMonetary">Doação em Dinheiro</label>

            <input type="radio" id="selectGoods" name="donationType" value="goods">
            <label for="selectGoods">Doação de Bens (Roupas, Comida, etc.)</label>
        </div>

        <!-- ---------------------------------------------------- -->
        <!-- 1. FORMULÁRIO DE DOAÇÃO EM DINHEIRO (Financeiro) -->
        <!-- ---------------------------------------------------- -->
        <div class="donation-form-container" id="monetaryForm">
            <h2>Doação Financeira</h2>
            <p style="color: #666; margin-bottom: 20px;">Você será redirecionado para a plataforma de pagamento após a confirmação.</p>
            
            <form action="processar_doacao.php" method="POST">
                
                <label for="valor">Valor da Doação (R$):</label>
                <input type="number" id="valor" name="valor" min="5.00" step="0.01" value="10.00" required>

                <label for="tipo_pagamento">Método de Pagamento:</label>
                <select id="tipo_pagamento" name="tipo_pagamento" required>
                    <option value="pix">PIX</option>
                    <option value="cartao">Cartão de Crédito</option>
                    <option value="boleto">Boleto Bancário</option>
                </select>

                <label for="nome_completo">Nome Completo (Opcional):</label>
                <input type="text" id="nome_completo" name="nome_completo">

                <button type="submit" class="button primary">Continuar para Pagamento</button>
            </form>
        </div>

        <!-- ---------------------------------------------------- -->
        <!-- 2. FORMULÁRIO DE DOAÇÃO DE BENS (Logístico) -->
        <!-- ---------------------------------------------------- -->
        <div class="donation-form-container" id="goodsForm">
            <h2>Doação de Itens Físicos</h2>
            <p style="color: #666; margin-bottom: 20px;">Selecione os itens abaixo e especifique a quantidade ou detalhes. Nossa equipe de logística entrará em contato para combinar a entrega ou coleta.</p>
            
            <form action="processar_doacao_bens.php" method="POST">
                
                <label>Itens para Doação:</label>
                
                <!-- CHECKBOXES COM CAMPOS DE QUANTIDADE DINÂMICOS -->
                <div class="checkbox-group-container">
                    <?php foreach ($tipos_de_bens as $value => $label): ?>
                        <div class="donation-item-row">
                            <div class="checkbox-control">
                                <!-- O data-target-id associa a checkbox ao seu campo de detalhes -->
                                <input type="checkbox" id="<?php echo $value; ?>" name="tipo_doacao_bem[]" value="<?php echo $value; ?>" data-target-id="details-<?php echo $value; ?>">
                                <label for="<?php echo $value; ?>" class="checkbox-label"><?php echo $label; ?></label>
                            </div>
                            <div id="details-<?php echo $value; ?>" class="item-details hidden">
                                <!-- O campo de detalhes é desabilitado por padrão e habilitado via JS -->
                                <input type="text" name="detalhes_<?php echo $value; ?>" placeholder="Ex: 5kg, 3 sacos grandes, 1 caixa, etc." disabled>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- FIM DO CAMPO DINÂMICO -->

                <label for="descricao_geral">Observações Gerais (Opcional):</label>
                <textarea id="descricao_geral" name="descricao_geral" rows="2" placeholder="Ex: Itens prontos para coleta no final de semana. Móveis no térreo."></textarea>

                <div class="contact-group">
                    <label for="nome_doador_bem">Seu Nome Completo:</label>
                    <input type="text" id="nome_doador_bem" name="nome_doador_bem" required>
                    
                    <label for="telefone_doador_bem">Telefone (para agendamento):</label>
                    <input type="tel" id="telefone_doador_bem" name="telefone_doador_bem" required placeholder="(XX) XXXXX-XXXX">
                    
                    <label for="endereco_doador_bem">Endereço Completo (Se for para Coleta):</label>
                    <textarea id="endereco_doador_bem" name="endereco_doador_bem" rows="2" placeholder="Rua, Número, Bairro, Cidade, Estado, CEP"></textarea>
                </div>
                

                <button type="submit" class="button primary">Enviar Proposta de Doação</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 SOS Sul. Solidariedade em Ação.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const monetaryForm = document.getElementById('monetaryForm');
            const goodsForm = document.getElementById('goodsForm');
            const donationTypeRadios = document.getElementsByName('donationType');
            const itemCheckboxes = document.querySelectorAll('.checkbox-group-container input[type="checkbox"]');

            // Função para alternar a exibição dos formulários (Financeiro vs. Bens)
            function toggleForms() {
                for (const radio of donationTypeRadios) {
                    if (radio.checked) {
                        if (radio.value === 'monetary') {
                            monetaryForm.style.display = 'block';
                            goodsForm.style.display = 'none';
                        } else if (radio.value === 'goods') {
                            monetaryForm.style.display = 'none';
                            goodsForm.style.display = 'block';
                        }
                        break;
                    }
                }
            }
            
            // Função para alternar a exibição dos campos de detalhe (Quantidade)
            function toggleDetailsField(event) {
                const checkbox = event.target;
                const targetId = checkbox.getAttribute('data-target-id');
                const detailsDiv = document.getElementById(targetId);
                const detailsInput = detailsDiv ? detailsDiv.querySelector('input[type="text"]') : null;

                if (detailsDiv && detailsInput) {
                    if (checkbox.checked) {
                        detailsDiv.classList.remove('hidden');
                        detailsInput.disabled = false;
                        detailsInput.focus(); // Foca no campo para facilitar a digitação
                    } else {
                        detailsDiv.classList.add('hidden');
                        detailsInput.disabled = true;
                        detailsInput.value = ''; // Limpa o valor ao desmarcar
                    }
                }
            }

            // Adiciona listeners para os seletores de tipo de doação
            donationTypeRadios.forEach(radio => {
                radio.addEventListener('change', toggleForms);
            });
            
            // Adiciona listeners para os checkboxes de itens
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleDetailsField);
            });

            // Inicializa a visualização (mostra o form de dinheiro por padrão)
            toggleForms();
        });
    </script>
</body>
</html>