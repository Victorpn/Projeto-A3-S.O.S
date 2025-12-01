# 🆘 Projeto SOS - Sistema de Gerenciamento de Ajuda e Apoio

![Badge de Status](https://img.shields.io/badge/Status-Em%20Desenvolvimento-yellow)

Este sistema web foi desenvolvido para gerenciar e otimizar as operações de apoio e ajuda humanitária, lidando com o fluxo de doações, gestão de voluntários e logística de bens.

---

## ✨ Visão Geral do Projeto

O **Projeto SOS** é uma plataforma crucial para a coordenação de esforços em situações de emergência.

### 🎯 Principais Módulos

1.  **Usuários e Autenticação:**
    * Cadastro de novos usuários e voluntários (`cadastro.php`, `processar_voluntario.php`).
    * Login e controle de acesso (`login.php`, `logout.php`).
2.  **Gerenciamento Administrativo (Admin):**
    * Painel de controle específico para administradores (`menuAdm.php`).
    * Geração e visualização de relatórios (`relatorios.php`).
3.  **Doações:**
    * Página para realizar doações (`doarAgora.php`).
    * Módulo para gerenciar o status e o acompanhamento das doações (`gerenciar_doacoes.php`).
4.  **Logística de Bens:**
    * Controle de entrada, saída e distribuição dos itens doados (`gerenciar_logistica_bens.php`).
5.  **Visualização Geográfica:**
    * Integração com API de Mapas para visualização de eventos ou logística, como a marcação de trajetos de desastres (evidenciado pelo commit: *Api Mapa - trajeto do tornado em Rio Bonito do Iguaçu* no `menuUser.php`).

---

## 💻 Tecnologias Utilizadas

| Categoria | Detalhe | Arquivos de Referência |
| :---: | :--- | :--- |
| **Backend** | **PHP** (Linguagem principal de script) | `login.php`, `processar_*.php`, etc. |
| **Banco de Dados** | **SQL** (Conexão para persistência de dados) | `conexao.php` |
| **Integração BI** | **Power BI** (Para visualização e análise de dados) | `A3.pbix` |
| **Web Mapping** | **API de Mapas** (Para funções de localização e visualização de desastres) | `menuUser.php` |

---

## 🚀 Guia de Configuração (Setup)

Para rodar este projeto localmente, siga os passos abaixo:

### Pré-requisitos

* Servidor Web (Apache) configurado (Ex: XAMPP, WAMP).
* Banco de Dados SQL (MySQL ou MariaDB) configurado.
* PHP instalado e configurado.

### Passos

1.  **Clone o Repositório:**
    ```bash
    git clone [https://github.com/jlesnioviski-droid/sos](https://github.com/jlesnioviski-droid/sos)
    ```
2.  **Configuração do Servidor:**
    * Mova a pasta clonada para o diretório de documentos raiz do seu servidor web (ex: `htdocs/`).
3.  **Configuração do Banco de Dados:**
    * Crie um novo banco de dados no seu servidor SQL.
    * **IMPORTANTE:** Atualize o arquivo `conexao.php` com as credenciais do seu banco de dados (`host`, `username`, `password`, `dbname`).
4.  **Acesso:**
    * Acesse o sistema pelo seu navegador, geralmente em: `http://localhost/sos/login.php`

---

## 🧑‍💻 Autores

Este projeto foi desenvolvido por:

* **Joao vitor lesniovisk** (`172212520`)
* **Joao vitor antonietto penteado** (`172214924`)
* **Victor Panatta Nogueira** (`172212648`)

---

## 🤝 Contribuições

Sinta-se à vontade para contribuir! Se tiver sugestões ou encontrar bugs, por favor, abra uma *issue* ou envie um *Pull Request*.

---
