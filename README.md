# Dashtzad Command Center

A private command center built on Laravel + Filament for managing operations, data, and integrations from a single admin panel.

## Status

> **Phase Zero** — Foundation documentation only. Laravel and Filament installation pending a real environment with Packagist access.

## Tech Stack

- **Backend:** Laravel 11
- **Admin Panel:** Filament 3
- **Database:** MySQL 8 / PostgreSQL 16
- **PHP:** 8.2+

## Quick Start (Local / VPS)

Requires Composer with Packagist access.

```bash
composer create-project laravel/laravel dashtzad-command-center
cd dashtzad-command-center
composer require filament/filament:"^3.0" -W
php artisan filament:install --panels
php artisan migrate
php artisan make:filament-user
```

Then start the dev server:

```bash
php artisan serve
```

Visit `http://localhost:8000/admin`.

## Documentation

- [Setup Guide](docs/setup.md)
- [Architecture](docs/architecture.md)
- [Roadmap](ROADMAP.md)
