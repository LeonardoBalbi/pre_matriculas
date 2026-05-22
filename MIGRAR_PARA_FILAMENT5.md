# Migração inicial para Filament PHP v5

Este pacote foi ajustado como ponto de partida para sair do Laravel Nova e instalar Filament PHP v5.

## Atenção

O projeto original usa Laravel Nova em `app/Nova`. A migração automática completa de Nova para Filament não é 100% segura, porque Actions, Lenses, Metrics e campos personalizados precisam ser reescritos manualmente.

## Comandos no seu PC/servidor

```bash
composer update -W
php artisan filament:install --panels
php artisan optimize:clear
php artisan migrate
```

Depois acesse:

```text
/seu-dominio/admin
```

## Gerar resources do Filament v5

Rode um por vez:

```bash
php artisan make:filament-resource Matricula --generate
php artisan make:filament-resource Escola --generate
php artisan make:filament-resource Turma --generate
php artisan make:filament-resource Vagas --generate
php artisan make:filament-resource Candidato --generate
php artisan make:filament-resource Bairro --generate
php artisan make:filament-resource Distrito --generate
php artisan make:filament-resource StatusMatricula --generate
php artisan make:filament-resource TurmaTipo --generate
php artisan make:filament-resource TipoDeficiencia --generate
```

## O que já foi alterado

- `composer.json` atualizado para PHP `^8.2`, Laravel `^12.0` e `filament/filament:^5.0`.
- Pacotes do Laravel Nova foram removidos do `composer.json`.
- `App\Providers\NovaServiceProvider` foi removido de `config/app.php`.
- Criado `App\Providers\Filament\AdminPanelProvider` para painel em `/admin`.

## O que ainda precisa revisar

- Converter `app/Nova/Actions` para actions do Filament.
- Converter `app/Nova/Filters` para filtros do Filament.
- Converter `app/Nova/Metrics` para widgets do Filament.
- Conferir campos com nomes antigos ou erros de relacionamento nos models.
- Remover `app/Nova` somente depois que todos os resources do Filament estiverem funcionando.
