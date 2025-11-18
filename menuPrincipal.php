
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SOS Sul: Ajuda às Vítimas das Chuvas</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    /*
 * --------------------------------
 * 1. Configurações Globais (Reset)
 * --------------------------------
 */
:root {
    /* Cores */
    --cor-primaria: #007bff; /* Azul vibrante para ação (Doar Agora) */
    --cor-secundaria: #28a745; /* Verde para voluntariado */
    --cor-destaque: #dc3545; /* Vermelho para urgência/alerta */
    --cor-fundo: #f8f9fa; /* Fundo claro */
    --cor-texto: #343a40; /* Texto escuro */
    --cor-clara: #ffffff; /* Branco */
    --cor-rodape: #6c757d; /* Cinza para o rodapé */

    /* Fontes */
    --fonte-principal: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: var(--fonte-principal);
    line-height: 1.6;
    color: var(--cor-texto);
    background-color: var(--cor-fundo);
}

a {
    text-decoration: none;
    color: var(--cor-primaria);
    transition: color 0.3s;
}

a:hover {
    color: var(--cor-destaque);
}

/*
 * --------------------------------
 * 2. Estilo do Cabeçalho (Hero Section)
 * --------------------------------
 */
.hero {
    background: var(--cor-primaria); /* Cor de fundo principal */
    color: var(--cor-clara);
    padding: 4rem 1.5rem; /* Preenchimento superior/inferior grande */
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.hero h1 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    border-bottom: 3px solid var(--cor-clara);
    display: inline-block;
    padding-bottom: 5px;
}

.hero p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

/*
 * --------------------------------
 * 3. Botões de Ação
 * --------------------------------
 */
.buttons {
    display: flex;
    justify-content: center;
    gap: 15px; /* Espaço entre os botões */
    flex-wrap: wrap; /* Permite que os botões quebrem a linha em telas pequenas */
}

.button {
    display: inline-block;
    padding: 12px 25px;
    border-radius: 5px;
    font-weight: bold;
    text-transform: uppercase;
    transition: background-color 0.3s, transform 0.2s;
    border: 2px solid var(--cor-clara); /* Borda branca padrão */
    color: var(--cor-clara);
}

/* Estilo principal para Doar Agora */
.button.primary {
    background-color: var(--cor-destaque); /* Vermelho forte para urgência */
    border-color: var(--cor-destaque);
    color: var(--cor-clara);
}

.button.primary:hover {
    background-color: #c82333; /* Um pouco mais escuro ao passar o mouse */
    transform: translateY(-2px);
}

/* Estilo secundário para Ser Voluntário */
.button.secondary {
    background-color: var(--cor-secundaria); /* Verde para esperança/ação */
    border-color: var(--cor-secundaria);
    color: var(--cor-clara);
}

.button.secondary:hover {
    background-color: #1e7e34;
    transform: translateY(-2px);
}

/* Estilo para Login e Cadastro */
.button:not(.primary):not(.secondary) {
    background-color: transparent;
    border-color: var(--cor-clara);
}

.button:not(.primary):not(.secondary):hover {
    background-color: rgba(255, 255, 255, 0.1); /* Um leve fundo transparente */
    transform: translateY(-1px);
}

/*
 * --------------------------------
 * 4. Conteúdo Principal (Main Content)
 * --------------------------------
 */
.content {
    max-width: 1200px;
    margin: 3rem auto;
    padding: 0 1.5rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Layout responsivo em grade */
    gap: 30px;
}

.content section {
    padding: 20px;
    background-color: var(--cor-clara);
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.content h2 {
    color: var(--cor-primaria);
    font-size: 1.8rem;
    margin-bottom: 1rem;
    border-left: 5px solid var(--cor-destaque);
    padding-left: 10px;
}

/* Estilo para a seção "news" */
.news p {
    margin-bottom: 1rem;
}

#latest-news {
    margin: 1.5rem 0;
    padding: 15px;
    border: 1px dashed #ccc;
    background-color: #fff3cd; /* Fundo amarelo claro para notícias */
    border-radius: 5px;
}

.cta-more {
    font-style: italic;
    font-weight: bold;
    color: var(--cor-destaque);
}

/* Estilo para a seção "about-us" (Lista) */
.about-us ul {
    list-style: none; /* Remove bolinhas */
    padding-left: 0;
}

.about-us li {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
    font-weight: 500;
    position: relative;
    padding-left: 25px;
}

.about-us li::before {
    content: '✅'; /* Ícone visual */
    position: absolute;
    left: 0;
    color: var(--cor-secundaria);
    font-size: 1.1em;
}

/* Estilo para a seção "impact" */
.impact p {
    font-size: 1.1rem;
    margin-bottom: 1rem;
}


/*
 * --------------------------------
 * 5. Rodapé (Footer)
 * --------------------------------
 */
footer {
    background-color: var(--cor-rodape);
    color: var(--cor-fundo);
    text-align: center;
    padding: 1.5rem 1rem;
    font-size: 0.9rem;
    margin-top: 3rem;
}

footer p {
    margin: 0.5rem 0;
}
  </style>
</head>
<body>
  <header class="hero">
    <h1>SOS Sul: Ajuda às Vítimas das Chuvas</h1>
    <p>As fortes chuvas recentes deixaram centenas de famílias desalojadas no Rio Grande do Sul. Sua ajuda pode fazer a diferença.</p>
    <div class="buttons">
      <a href="login.php" class="button primary" target="_blank">Doar Agora</a>
      <a href="serVoluntario.php" class="button secondary" target="_blank">Ser Voluntário</a>
      <a href="login.php" class="button" target="_blank">Login</a>
      <a href="cadastro.php" class="button" target="_blank">Cadastrar</a>
    </div>
  </header>

  <main class="content">
    <section class="news">
      <h2>Últimas Notícias</h2>
      <p>Chuvas intensas afetaram dezenas de cidades no Rio Grande do Sul recentemente, causando alagamentos, destelhamentos e mais de 700 pessoas desalojadas. :contentReference[oaicite:2]{index=2}</p>
      <div id="latest-news">
        <p><strong>Desastre climático no RS</strong> — <a href="https://www.uol.com.br/cotidiano/ultimas-noticias/2025/08/24/chuvas-rs.htm" target="_blank">Leia mais</a></p>
        <p><strong>Previsão de mais temporais</strong> — <a href="https://portal.inmet.gov.br/noticias/temporais-persistem-nesta-sexta-e-s%C3%A1bado-na-regi%C3%A3o-sul-do-brasil" target="_blank">Leia mais</a></p>
      </div>
      <p class="cta-more">Acompanhe os boletins da Defesa Civil e do INMET para ficar por dentro da situação.</p>
    </section>

    <section class="about-us">
      <h2>Como Sua Doação Vai Ajudar</h2>
      <ul>
        <li>Distribuição de alimentos, água potável e kits de higiene.</li>
        <li>Suporte para reconstrução de casas destelhadas.</li>
        <li>Acolhimento e suporte para famílias desabrigadas.</li>
        <li>Apoio psicológico para vítimas do desastre.</li>
      </ul>
    </section>

    <section class="impact">
      <h2>Impacto da Crise</h2>
      <p>Segundo boletins oficiais, mais de 700 pessoas ficaram desabrigadas ou desalojadas. :contentReference[oaicite:3]{index=3}</p>
      <p>Especialistas apontam que eventos climáticos extremos como este estão se tornando mais frequentes no Sul do Brasil. :contentReference[oaicite:4]{index=4}</p>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 SOS Sul. Solidariedade em Ação.</p>
    <p>Dados e fontes: INMET, Defesa Civil, Imprensa local.</p>
  </footer>
</body>
</html>

