# projetoAgenda

Sistema de agenda de contatos simples feito em **PHP**, **MySQL**, **PDO** e **Bootstrap**.
Permite cadastrar, listar, visualizar, editar e remover contatos (CRUD completo), com saída
protegida contra XSS e testes automatizados com PHPUnit.

## Funcionalidades

- Listagem de contatos
- Cadastro de novos contatos (nome, telefone, observações)
- Visualização de um contato
- Edição e remoção de contatos
- Proteção contra SQL Injection (prepared statements) e XSS (escape na saída)

## Requisitos

- PHP 8.1+ (testado em PHP 8.4) com as extensões `pdo_mysql` (app) e `pdo_sqlite` (testes)
- MySQL 8+ (ou MariaDB)
- [Composer](https://getcomposer.org/) (para rodar os testes)

## Estrutura do projeto

```
projetoAgenda/
├── public/              # Raiz web (document root)
│   ├── index.php        # Listagem de contatos
│   ├── create.php       # Formulário de cadastro
│   ├── edit.php         # Formulário de edição
│   ├── show.php         # Detalhe do contato
│   ├── process.php      # Endpoint que delega para config/process.php
│   ├── css/             # Estilos
│   └── img/             # Imagens
├── config/              # Configuração e lógica (fora da raiz web)
│   ├── connection.php   # Conexão PDO (lê variáveis do .env)
│   ├── process.php      # Lógica de requisição (CRUD + seleção)
│   ├── url.php          # Define a BASE_URL
│   └── database.sql     # Script de criação do banco e tabela
├── templates/           # header.php, footer.php, backbtn.php
├── src/                 # Classes (namespace App\)
│   ├── ContactRepository.php  # Acesso ao banco (CRUD)
│   └── Helpers.php            # Funções utilitárias (escape/sanitize)
├── tests/               # Testes PHPUnit
├── composer.json
├── phpunit.xml
├── .env.example         # Modelo de variáveis de ambiente
└── .gitignore
```

## Configuração

1. Clone o repositório e instale as dependências:

   ```bash
   composer install
   ```

2. Crie o arquivo `.env` a partir do modelo e ajuste as credenciais:

   ```bash
   cp .env.example .env
   ```

   Variáveis disponíveis:

   ```env
   DB_HOST=localhost
   DB_NAME=agenda
   DB_USER=root
   DB_PASS=
   ```

3. Crie o banco de dados e a tabela importando o script SQL:

   ```bash
   mysql -u SEU_USUARIO -p < config/database.sql
   ```

   O script cria o banco `agenda` e a tabela `contacts` (`id`, `name`, `phone`,
   `observations`, `created_at`).

## Executando a aplicação

Suba o servidor embutido do PHP usando `public/` como raiz:

```bash
php -S localhost:8000 -t public
```

Acesse: http://localhost:8000

> Em Apache/Nginx, configure o *document root* para a pasta `public/`.
> As pastas `config/`, `src/` e `templates/` ficam fora da raiz web por segurança.

## Testes

A suíte de testes usa PHPUnit e um banco SQLite em memória (não precisa de MySQL):

```bash
composer test
# ou
./vendor/bin/phpunit
```

Os testes cobrem o CRUD completo (`ContactRepository`) e as funções de escape/sanitização (`Helpers`).

## Tecnologias

- PHP + PDO
- MySQL
- Bootstrap 4 + Font Awesome (via CDN)
- PHPUnit
