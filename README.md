# Laravel – Sitemap

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/laravel-sitemap.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/laravel-sitemap)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Gera o `sitemap.xml` do site rastreando a própria aplicação (via [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap)), agenda a geração diária e expõe a rota `/sitemap.xml`.

## Requisitos

- Laravel ^12.0 | ^13.0
- spatie/laravel-sitemap ^8.2

## Instalação

```bash
composer require agenciafmd/laravel-sitemap:dev-master
```

O service provider é registrado automaticamente (package discovery). Não há migrações nem arquivo de configuração para publicar.

## Configuração

O pacote usa as configurações da própria aplicação:

| Config | Uso |
|---|---|
| `app.url` (`APP_URL`) | URL inicial do rastreamento |
| `filesystems.default` (`FILESYSTEM_DISK`) | Disco onde o `sitemap.xml` é gravado |
| `filament-admix.schedule.minutes` | Minuto do agendamento diário (padrão `00`, ou seja, `04:00`) |

```dotenv
APP_URL=https://www.exemplo.com.br
FILESYSTEM_DISK=public
```

> O `APP_URL` precisa estar acessível a partir do servidor (ou container) que executa a fila, pois o sitemap é gerado rastreando o site.

## Uso

### Gerando o sitemap

```bash
php artisan sitemap:generate
```

O comando **enfileira** a geração na fila `low`. O job:

- rastreia o site a partir do `APP_URL`;
- descarta as URLs com query string (`?`);
- ordena as URLs;
- grava `sitemap.xml` na raiz do disco padrão, com visibilidade pública.

### Agendamento

O comando é registrado no scheduler para rodar diariamente às `04:{minutes}` (`withoutOverlapping`), com saída em `storage/logs/command-sitemap-generate-YYYY-MM-DD.log`. Basta o scheduler da aplicação estar ativo:

```bash
php artisan schedule:work
```

### Rota

A rota `/sitemap.xml` (grupo `web`) faz um redirecionamento permanente (301) para `Storage::url('sitemap.xml')`.

## Filas

Como a geração é feita em fila, garanta que um worker esteja processando a fila `low`:

```bash
php artisan queue:work --queue=high,default,low
```

## Testes

Os testes ficam em `tests/` e usam o `Tests\TestCase` da aplicação, então são executados de dentro do projeto que instala o pacote:

```bash
vendor/bin/pest packages/agenciafmd/laravel-sitemap/tests
```

## Licença

Este pacote é software livre e está disponível nos termos da licença MIT.
