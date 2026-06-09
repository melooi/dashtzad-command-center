# Architecture Overview

## High-Level Structure

```
dashtzad-command-center/
├── app/
│   ├── Filament/
│   │   ├── Pages/          # Custom Filament pages (e.g. Dashboard)
│   │   ├── Resources/      # CRUD resources (each maps to a model)
│   │   └── Widgets/        # Dashboard widgets
│   ├── Models/             # Eloquent models
│   ├── Services/           # Business logic, external API clients
│   └── Jobs/               # Queued background jobs
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── docs/                   # This documentation
├── public/
├── resources/
│   └── views/
├── routes/
│   └── web.php
└── storage/
```

> This structure is the standard Laravel layout. It does not exist yet — it will be created when `composer create-project` is run on a real environment.

---

## Key Layers

### Admin Panel (Filament 3)

All UI lives inside the Filament admin panel at `/admin`. Filament generates:
- **Resources** — list/create/edit/view pages backed by Eloquent models
- **Pages** — standalone pages (e.g. a custom dashboard or settings page)
- **Widgets** — stats, charts, and tables embeddable in dashboard pages

### Models & Database

Standard Laravel Eloquent models. Migrations are version-controlled in `database/migrations/`. No raw SQL — all schema changes go through migrations.

### Services Layer

External integrations (APIs, webhooks, third-party clients) will live in `app/Services/`. Each service is a plain PHP class injected via Laravel's service container. No API keys or credentials are stored in code — all via `.env`.

### Jobs & Queues

Background tasks use Laravel's queue system (`php artisan queue:work`). In development `QUEUE_CONNECTION=sync` runs jobs inline. Production will use `database` or `redis`.

---

## Filament Panel Configuration

After `php artisan filament:install --panels`, the panel provider lives at:

```
app/Providers/Filament/AdminPanelProvider.php
```

This is where navigation, middleware, plugins, and theme are registered.

---

## Authentication

Filament uses Laravel's built-in authentication. The `users` table is seeded with the first admin via:

```bash
php artisan make:filament-user
```

Role-based access (Phase One) will use **Spatie Laravel Permission** (`spatie/laravel-permission`) integrated with Filament's resource access policies.

---

## Deployment Target

- **Local dev:** `php artisan serve` or Laravel Herd / Valet (Mac)
- **VPS:** Nginx + PHP-FPM, systemd queue worker, MySQL/PostgreSQL
- **Future:** Docker Compose (Phase Four)
