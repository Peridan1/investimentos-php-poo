# 📈 Gestão de Ativos - Versão Refatorada

## Este projeto é uma evolução de um sistema de controle de investimentos, transformado de um script procedural para uma aplicação **MVC (Model-View-Controller)** robusta, com design moderno e foco em segurança.

## 🚀 Principais Melhorias e Tecnologias

- **Arquitetura MVC Real**: Separação clara de responsabilidades entre Modelos, Controladores e Visualizações.
- **Interface Premium**: Dashboard inspirado no tema "Falcon", utilizando **Bootstrap 5**, FontAwesome e gráficos dinâmicos com **Chart.js**.
- **Segurança**:
  - Proteção contra ataques **CSRF** em todos os formulários.
  - Autenticação de usuários com proteção de rotas.
  - Sanitização de inputs para evitar SQL Injection.
- **Roteamento Inteligente**: Sistema de rotas amigáveis para URLs limpas e SEO.
- **Integração com APIs**:
  - Cotações de moedas em tempo real via AwesomeAPI.
  - Notícias do mercado financeiro via NewsAPI.
- **Dockerizado**: Pronto para rodar em qualquer ambiente com Docker e Docker Compose.

## 🛠️ Stack Técnica

- **Linguagem**: PHP 8.1+
- **Frontend**: HTML5, CSS3 (Vanilla), Bootstrap 5, Javascript
- **Banco de Dados**: MySQL 8.0
- **Ambiente**: Docker & Docker Compose

## 📂 Estrutura do Projeto

```text
versao-refatorada/

├── assets/             # Arquivos estáticos (CSS, JS, Imagens)
├── classes/            # Lógica de Negócio (Autoload configurado)
│   ├── controllers/    # Controladores da aplicação
│   ├── core/           # Núcleo do sistema (Router, Database, BaseModel)
│   ├── models/         # Classes de acesso ao banco (Modelos)
│   └── services/       # Integrações com APIs externas
├── config/             # Configurações globais e banco de dados
├── includes/           # Componentes reutilizáveis (Header, Footer, Helpers)
├── routes/             # Definição das rotas do sistema
└── views/              # Templates HTML/PHP (Interface do usuário)
```

## ⚙️ Como Executar

1.  Clone este repositório.
2.  Crie um arquivo `.env` na raiz (baseado no `.env-example`).
3.  Configure sua `NEWS_API_KEY` (opcional para notícias).
4.  Suba os containers:
    ```bash
    docker-compose up -d
    ```
5.  Acesse `http://localhost:8080`.

---

## 🎯 Objetivo da Refatoração

Este projeto demonstra o domínio de padrões de projeto (Design Patterns), organização de código limpo (Clean Code) e a transição de um sistema legado para uma arquitetura moderna preparada para escala e manutenção facilitada.
