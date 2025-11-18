<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seja um Voluntário SOS Sul</title>
    <!-- Carregamento do Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-blue': '#00529B', // Cor principal, inspirada na SOS Sul
                        'accent-yellow': '#FFC72C', // Cor de destaque
                        'background-light': '#F8F8F8',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        /* Estilo customizado para garantir que o textarea e inputs se ajustem corretamente */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F8F8;
            color: #333;
        }
        .form-input, .form-select, .form-textarea {
            transition: all 0.2s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: #00529B;
            box-shadow: 0 0 0 3px rgba(0, 82, 155, 0.2);
        }
    </style>
</head>
<body class="min-h-screen antialiased">

    <!-- Cabeçalho Principal (Hero Section) -->
    <header class="bg-primary-blue text-white py-12 px-4 shadow-xl">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-3 leading-tight">
                Seja um Voluntário SOS Sul
            </h1>
            <p class="text-xl md:text-2xl font-light">
                Preencha o formulário abaixo e nos ajude a levar esperança ao Rio Grande do Sul.
            </p>
        </div>
    </header>

    <main class="content p-4 md:p-8">
        
        <!-- Formulário de Inscrição -->
        <section class="max-w-2xl mx-auto">
            <div class="bg-white shadow-2xl rounded-xl p-6 md:p-10 border-t-4 border-accent-yellow">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Formulário de Inscrição</h2>
                
                <!-- O action foi mantido como no PHP original, mas a funcionalidade não está implementada no HTML estático -->
                <form action="processar_voluntario.php" method="POST" class="space-y-6">
                    
                    <!-- Nome -->
                    <div>
                        <label for="nome" class="block text-sm font-medium text-primary-blue mb-1">Nome Completo:</label>
                        <input type="text" id="nome" name="nome" required 
                               class="form-input w-full p-3 border border-gray-300 rounded-lg focus:ring-primary-blue focus:border-primary-blue"
                               placeholder="Seu nome completo">
                    </div>

                    <!-- E-mail -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-primary-blue mb-1">E-mail:</label>
                        <input type="email" id="email" name="email" required
                               class="form-input w-full p-3 border border-gray-300 rounded-lg focus:ring-primary-blue focus:border-primary-blue"
                               placeholder="seu.email@exemplo.com">
                    </div>

                    <!-- Telefone -->
                    <div>
                        <label for="telefone" class="block text-sm font-medium text-primary-blue mb-1">Telefone (com DDD):</label>
                        <input type="tel" id="telefone" name="telefone" required
                               class="form-input w-full p-3 border border-gray-300 rounded-lg focus:ring-primary-blue focus:border-primary-blue"
                               placeholder="(XX) XXXXX-XXXX">
                    </div>

                    <!-- Disponibilidade -->
                    <div>
                        <label for="disponibilidade" class="block text-sm font-medium text-primary-blue mb-1">Qual a sua disponibilidade principal?</label>
                        <select id="disponibilidade" name="disponibilidade" required
                                class="form-select w-full p-3 border border-gray-300 rounded-lg bg-white focus:ring-primary-blue focus:border-primary-blue">
                            <option value="">Selecione uma opção</option>
                            <option value="diaria">Diária</option>
                            <option value="fins_semana">Apenas Fins de Semana</option>
                            <option value="esporadica">Esporádica (Quando possível)</option>
                            <option value="online">Apenas Remoto/Online</option>
                        </select>
                    </div>

                    <!-- Áreas de Atuação (Checkbox Group) -->
                    <div>
                        <label class="block text-sm font-medium text-primary-blue mb-2">Quais áreas de atuação você tem interesse/experiência?</label>
                        <div class="checkbox-group bg-blue-50 border border-dashed border-primary-blue p-4 rounded-lg space-y-2">
                            <label class="flex items-center text-gray-700">
                                <input type="checkbox" name="area[]" value="logistica" class="form-checkbox h-4 w-4 text-primary-blue rounded focus:ring-primary-blue mr-2"> Logística e Transporte
                            </label>
                            <label class="flex items-center text-gray-700">
                                <input type="checkbox" name="area[]" value="saude" class="form-checkbox h-4 w-4 text-primary-blue rounded focus:ring-primary-blue mr-2"> Saúde e Primeiros Socorros
                            </label>
                            <label class="flex items-center text-gray-700">
                                <input type="checkbox" name="area[]" value="cozinha" class="form-checkbox h-4 w-4 text-primary-blue rounded focus:ring-primary-blue mr-2"> Preparação de Alimentos
                            </label>
                            <label class="flex items-center text-gray-700">
                                <input type="checkbox" name="area[]" value="psicologico" class="form-checkbox h-4 w-4 text-primary-blue rounded focus:ring-primary-blue mr-2"> Suporte Psicológico
                            </label>
                            <label class="flex items-center text-gray-700">
                                <input type="checkbox" name="area[]" value="construcao" class="form-checkbox h-4 w-4 text-primary-blue rounded focus:ring-primary-blue mr-2"> Reconstrução/Pequenos Reparos
                            </label>
                            <label class="flex items-center text-gray-700">
                                <input type="checkbox" name="area[]" value="online" class="form-checkbox h-4 w-4 text-primary-blue rounded focus:ring-primary-blue mr-2"> Mídias Sociais / Ajuda Remota
                            </label>
                        </div>
                    </div>
                    
                    <!-- Mensagem/Motivação -->
                    <div>
                        <label for="mensagem" class="block text-sm font-medium text-primary-blue mb-1">Fale um pouco sobre você e sua motivação:</label>
                        <textarea id="mensagem" name="mensagem" rows="4" 
                                  class="form-textarea w-full p-3 border border-gray-300 rounded-lg focus:ring-primary-blue focus:border-primary-blue"
                                  placeholder="Compartilhe sua história e como deseja ajudar."></textarea>
                    </div>

                    <!-- Botão de Envio -->
                    <button type="submit" 
                            class="button primary w-full py-3 px-4 bg-primary-blue text-white font-bold text-lg rounded-lg hover:bg-blue-700 transition duration-300 shadow-md transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-primary-blue focus:ring-opacity-50">
                        Enviar Minha Inscrição
                    </button>
                </form>
            </div>
        </section>

        <!-- Seção Importante -->
        <section class="max-w-2xl mx-auto mt-12 mb-8 text-center p-6 bg-yellow-50 border border-yellow-200 rounded-xl shadow-inner">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Importante</h2>
            <p class="text-gray-600">Seus dados serão analisados pela nossa equipe. Entraremos em contato para formalizar o cadastro e alinhar os detalhes da sua ajuda.</p>
        </section>
        
    </main>

    <!-- Rodapé -->
    <footer class="bg-gray-800 text-white p-4 mt-auto">
        <div class="max-w-4xl mx-auto text-center">
            <p class="text-sm">&copy; 2025 SOS Sul. Solidariedade em Ação.</p>
        </div>
    </footer>
</body>
</html>