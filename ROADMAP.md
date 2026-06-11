# Roadmap

## انجام‌شده

- [x] ساختار repository و `.gitignore`
- [x] Laravel 13 + Filament 4 نصب و پیکربندی شده
- [x] فونت IRANYekanX self-hosted
- [x] Layout RTL + Sidebar + Header + Activity Drawer
- [x] سیستم tab switching با JS
- [x] Blade components: nav, ui, layout
- [x] Command Center UI (section-based)
- [x] صفحه Connections با ۱۳ سرویس (frontend-only)
- [x] localStorage امن — بدون ذخیره credentials
- [x] Sidebar responsive: collapse/expand دسکتاپ + drawer موبایل
- [x] Deploy روی VPS (Nginx + PHP-FPM + MariaDB)
- [x] SSL با Certbot
- [x] Production URL: `https://tools.dashtzad.com`

---

## مرحله بعد — Backend Connections

- [ ] جدول `service_connections` در database
- [ ] رمزنگاری credentials با `encrypt()` Laravel
- [ ] API برای ذخیره، خواندن، و حذف connection
- [ ] migration credentials از localStorage به backend
- [ ] تست اتصال live (ping) برای هر سرویس

## احراز هویت و دسترسی

- [ ] User authentication (Laravel Breeze یا Filament Auth)
- [ ] Role / Permission با Spatie Laravel Permission
- [ ] Filament resource access policies

## ماژول‌های کاری

- [ ] ماژول محصولات (CRUD از WooCommerce)
- [ ] ماژول وظایف (Kanban)
- [ ] ماژول محتوا (وبلاگ، دستور پخت)
- [ ] ماژول فروش (سفارش‌ها، مشتریان)

## یکپارچگی‌های واقعی

- [ ] OpenAI / Claude API call از backend
- [ ] ارسال پیامک از طریق MSGway
- [ ] Telegram Bot webhook
- [ ] Google Analytics data fetch
- [ ] WordPress REST API sync

## زیرساخت

- [ ] CI pipeline (test + lint)
- [ ] Queue worker برای background jobs
- [ ] Health check endpoint
- [ ] Audit log برای action‌های حساس
