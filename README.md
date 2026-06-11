# Dashtzad Command Center

پنل فرماندهی اختصاصی دشت‌زاد برای مدیریت عملیات، محتوا، فروش، و یکپارچگی‌های خارجی از یک رابط واحد.

## وضعیت

**در تولید (Production)** — نسخه `v0.1-production` در دسترس است.

- آدرس: [https://tools.dashtzad.com](https://tools.dashtzad.com)
- UI Command Center پیاده‌سازی شده
- صفحه Connections (frontend-only) فعال است
- Backend واقعی برای اتصالات در roadmap آینده قرار دارد

## Stack فنی

| لایه | ابزار |
|------|------|
| Backend | Laravel 13 |
| Admin Panel | Filament 4 |
| PHP | 8.4 (production) |
| Database | MariaDB |
| Web Server | Nginx + PHP-FPM |
| Frontend | Vite + Tailwind CSS v4 |
| فونت | IRANYekanX (self-hosted) |

## راه‌اندازی محلی

```bash
git clone https://github.com/melooi/dashtzad-command-center.git
cd dashtzad-command-center
composer install
cp .env.example .env
php artisan key:generate
# مقادیر DB را در .env تنظیم کن
php artisan migrate
npm install
npm run dev
php artisan serve
```

## مستندات

- [راهنمای نصب](docs/setup.md)
- [معماری](docs/architecture.md)
- [محدوده MVP](docs/mvp-scope.md)
- [Design System](docs/design/design-system.md)
- [قوانین UI](docs/design/ui-rules.md)
- [کامپوننت‌ها](docs/design/components.md)
- [صفحه Connections](docs/design/connections-page.md)
- [Roadmap](ROADMAP.md)
- [Security](SECURITY.md)
