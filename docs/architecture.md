# Architecture Overview

## Stack واقعی

| لایه | ابزار | نسخه |
|------|------|------|
| Framework | Laravel | 13 |
| Admin Panel | Filament | 4 |
| PHP | PHP-FPM | 8.4 |
| Database | MariaDB | — |
| Web Server | Nginx | — |
| Asset Pipeline | Vite + Tailwind CSS v4 | — |
| Version Control | GitHub (main branch = production) | — |

---

## ساختار فایل‌های مهم

```
dashtzad-command-center/
├── app/
│   ├── Filament/          # پنل ادمین Filament (در حال توسعه)
│   ├── Models/            # Eloquent models
│   ├── Services/          # کلاینت‌های API خارجی (Planned)
│   └── Jobs/              # Queue jobs (Planned)
├── docs/                  # مستندات پروژه
│   └── design/            # Design system و UI rules
├── resources/
│   ├── css/app.css        # Tailwind v4 + فونت IRANYekanX
│   ├── js/app.js          # JS اصلی (tab switching، connections، modals)
│   └── views/
│       ├── components/    # Blade components (layout، nav، ui)
│       └── command-center/ # صفحات Command Center
│           └── sections/  # هر tab یک فایل جدا
├── public/
│   ├── build/             # خروجی Vite (git-ignored در پروژه‌های معمول)
│   └── fonts/             # IRANYekanX self-hosted
└── routes/web.php         # مسیرهای web
```

---

## Command Center — معماری UI

Command Center یک Single-Page App شبیه‌سازی‌شده با Blade است:

- یک صفحه PHP رندر می‌شود (`/`)
- هر section با `id="page-xxx"` و class `hidden` مخفی است
- `switchTab(id)` در `app.js` section فعال را نمایش می‌دهد
- Sidebar با `<x-nav.item tab="...">` و `<x-nav.subitem tab="...">` tab switching را trigger می‌کند
- توابع JS باید روی `window` ثبت شوند (Vite module scope ایزوله است)

---

## Asset Pipeline

```
resources/css/app.css  →  Vite + Tailwind v4  →  public/build/assets/app-xxx.css
resources/js/app.js    →  Vite (ES module)    →  public/build/assets/app-xxx.js
```

- `@vite(['resources/css/app.css', 'resources/js/app.js'])` در layout اصلی
- در production: `npm run build` خروجی minified با hash می‌سازد
- توابعی که از `onclick` در Blade صدا زده می‌شوند باید `window.xxx = fn` داشته باشند

---

## Deploy Flow

```
git push origin main
↓ (روی سرور)
git pull origin main
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Services Layer (Planned)

کلاینت‌های API خارجی در `app/Services/` قرار خواهند گرفت:

- هر سرویس یک PHP class جداگانه
- بدون API key در کد — همه از `.env` می‌آیند
- Credentials در database رمزنگاری‌شده ذخیره می‌شوند

---

## Authentication (Planned)

- Laravel built-in auth
- Filament panel auth
- Spatie Laravel Permission برای نقش و دسترسی
- Access policies روی هر Filament resource

---

## Queues (Planned)

- پیش‌فرض: `QUEUE_CONNECTION=sync` (local)
- Production: `database` یا `redis`
- موارد: ارسال SMS، تولید محتوا AI، sync محصولات WooCommerce
