# SOCEA — Sistema de Organização e Cobrança de Escritório de Advocacia

Sistema web em PHP para gestão de clientes, processos, agendamentos e anexos de um
escritório de advocacia. O projeto original dependia de um MySQL remoto com
credenciais embutidas no código; esta versão roda localmente com **SQLite + PDO**,
cria o schema automaticamente e aplica práticas básicas de segurança web.

## Stack

- PHP 8.1+ (testado com PHP 8.3)
- PDO SQLite (extensões `pdo_sqlite`, `sqlite3`, `fileinfo`, `mbstring`)
- HTML/CSS/JavaScript (jQuery local)
- Sem frameworks e sem dependências via Composer

## Como rodar

```bash
cd modelotcc

# 1) Cria o banco e o usuário administrador
php Scripts/init_db.php

# 2) Opcional: dados de demonstração (cliente, processo e agendamento)
php Scripts/init_db.php --demo

# 3) Sobe o servidor de desenvolvimento
php -S 127.0.0.1:8099 -t .
```

Acesse <http://127.0.0.1:8099/index.php>.

Para redefinir a senha do administrador em uma instalação existente:

```powershell
$env:SOCEA_ADMIN_SENHA = "uma-senha-forte"
php Scripts/init_db.php --reset-admin
```

### Login inicial

| E-mail | Senha |
| --- | --- |
| `admin@socea.local` | `Admin@12345` |

> **Troque a senha no primeiro acesso** (menu Início → Alterar minha senha) e/ou
> defina `SOCEA_ADMIN_EMAIL` e `SOCEA_ADMIN_SENHA` antes de criar o banco. Em
> bancos já existentes, use `init_db.php --reset-admin`.

## Variáveis de ambiente

| Variável | Padrão | Descrição |
| --- | --- | --- |
| `SOCEA_DB` | `dados/socea.sqlite` | Caminho do arquivo SQLite |
| `SOCEA_UPLOAD_DIR` | `dados/arquivos` | Pasta dos anexos (fora da área pública) |
| `SOCEA_ADMIN_EMAIL` | `admin@socea.local` | Login do administrador inicial |
| `SOCEA_ADMIN_SENHA` | `Admin@12345` | Senha do administrador inicial ou do `--reset-admin` |
| `SOCEA_UPLOAD_MAX` | `10485760` (10 MB) | Tamanho máximo por arquivo |

Exemplo no PowerShell:

```powershell
$env:SOCEA_DB = "C:\SOCEA2\dados\socea.sqlite"
$env:SOCEA_UPLOAD_DIR = "C:\SOCEA2\dados\anexos"
$env:SOCEA_ADMIN_SENHA = "uma-senha-forte"
php Scripts/init_db.php
```

## Funcionalidades

- Login com sessão, timeout por inatividade e logout por expiração.
- Cadastro de usuários (restrito ao administrador).
- Cadastro, busca e edição de clientes.
- Cadastro de processos vinculados ao cliente.
- Agenda por usuário com criação, edição e exclusão de compromissos.
- Upload múltiplo de anexos por processo, com validação de extensão/MIME e
  download autenticado.
- Painel inicial com totais e próximos compromissos.
- Alteração de senha com confirmação da senha atual.

## Segurança implementada

- Senhas com `password_hash`/`password_verify` e migração automática de senhas
  antigas em texto puro no primeiro login.
- Todas as consultas com prepared statements (PDO).
- CSRF em todos os formulários de escrita e nos handlers que alteram dados.
- Escape de saída com `htmlspecialchars(..., ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')`.
- Sessão com cookie `HttpOnly`, `SameSite=Lax`, `Secure` sob HTTPS e
  `session_regenerate_id` no login.
- Cabeçalhos `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`,
  `Permissions-Policy` e `Content-Security-Policy`.
- Uploads gravados fora da raiz pública, com nome aleatório, limite de tamanho e
  validação de MIME via `finfo`.
- `Scripts/Arquivos/.htaccess` e `modelotcc/.htaccess` bloqueiam acesso direto a
  anexos e a arquivos internos em Apache; o diretório `dados/` fica fora da raiz
  pública.
- Handlers de escrita exigem sessão autenticada (`protegePagina`).

## Estrutura

```text
SOCEA2/
├── modelotcc/               # raiz pública do site
│   ├── index.php            # login
│   ├── Inicio.php           # painel
│   ├── Cliente.php          # lista/busca de clientes
│   ├── PerfilCliente.php    # ficha do cliente + processos
│   ├── Processo.php         # processo + anexos
│   ├── Agenda.php           # agenda
│   ├── Cadastro*.php        # formulários
│   ├── RecuperarSenha.php   # alteração de senha
│   ├── Scripts/
│   │   ├── Conexao.php      # PDO/SQLite, schema e helpers
│   │   ├── Seguranca.php    # sessão, CSRF, headers e autorização
│   │   ├── init_db.php      # inicialização/seed (CLI)
│   │   ├── Anexos.php       # upload
│   │   ├── Arquivos.php     # download autenticado
│   │   └── ...              # handlers de cadastro/edição
│   └── tests/smoke.php      # teste de fumaça do banco
└── dados/                   # banco + anexos (fora da raiz pública, ignorado pelo Git)
```

## Testes

```bash
# Sintaxe de todos os arquivos
find modelotcc -name '*.php' -print0 | xargs -0 -n1 php -l

# Teste de fumaça (usa um banco temporário)
php modelotcc/tests/smoke.php
```

O workflow pronto está em `ci/github-actions.yml` (lint, teste de fumaça e smoke
HTTP). Para ativá-lo, copie o arquivo para `.github/workflows/ci.yml`; o token
do GitHub usado no push precisa do escopo `workflow` (`gh auth refresh -s workflow`).

## Limitações conhecidas

- O módulo de **Publicações** ainda é uma página informativa.
- Não há importação automática da base MySQL antiga; os dados precisam ser
  migrados manualmente (o schema SQLite está em `Scripts/Conexao.php`).
- O servidor embutido do PHP é apenas para desenvolvimento. Em produção use
  Apache/Nginx com HTTPS, `display_errors=Off` e as regras de `.htaccess`
  equivalentes no servidor web.
