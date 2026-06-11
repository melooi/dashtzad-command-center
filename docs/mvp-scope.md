# MVP Scope

## انجام‌شده (v0.1-production)

### زیرساخت

- [x] Laravel 13 + Filament 4 نصب و پیکربندی شده
- [x] MariaDB + Nginx + PHP-FPM روی VPS
- [x] SSL با Certbot — `https://tools.dashtzad.com`
- [x] Deploy از GitHub main branch
- [x] فونت IRANYekanX self-hosted

### UI Command Center

- [x] Layout اصلی RTL با Sidebar + Header + Activity Drawer
- [x] سیستم tab switching (JS + CSS)
- [x] Blade components: `layouts/app`، `sidebar`، `header`، `activity-drawer`
- [x] Nav components: `nav/item`، `nav/group`، `nav/subitem`
- [x] UI components: `ui/empty-state`، `ui/stat-card`، `ui/btn`
- [x] صفحات section در `resources/views/command-center/sections/`

### صفحه Connections (Frontend-only)

- [x] ۱۳ سرویس در ۵ گروه با کارت UI
- [x] مودال پیکربندی برای هر سرویس
- [x] وضعیت connected/disconnected با localStorage
- [x] قانون امنیتی: هیچ credential در localStorage ذخیره نمی‌شود
- [x] Secret inputs بعد از save از DOM پاک می‌شوند

---

## مرحله بعد

### Backend Connections (اولویت اول)

- [ ] جدول `service_connections` در database
- [ ] رمزنگاری credentials با Laravel `encrypt()`
- [ ] API endpoint برای ذخیره، خواندن، و حذف
- [ ] حذف وابستگی به localStorage

### احراز هویت

- [ ] User auth (Laravel / Filament)
- [ ] Role + Permission
- [ ] Access policies

### ماژول‌های کاری

- [ ] محصولات (WooCommerce sync)
- [ ] وظایف (Kanban)
- [ ] محتوای سایت
- [ ] فروش (سفارش‌ها)
- [ ] انبار

### یکپارچگی‌های واقعی

- [ ] OpenAI / Claude از backend
- [ ] MSGway SMS
- [ ] Telegram Bot
- [ ] Google Analytics
- [ ] WordPress REST API

### زیرساخت

- [ ] CI pipeline
- [ ] Queue worker
- [ ] Audit log
- [ ] Health check

---

## آنچه هنوز پیاده‌سازی نشده

- **Backend Connections:** اتصالات در localStorage هستند، نه database. Credentials ذخیره نمی‌شوند.
- **Auth:** هنوز هیچ سیستم احراز هویتی پیاده‌سازی نشده. پنل بدون login در دسترس است.
- **Filament Resources:** هنوز هیچ resource تعریف نشده.
- **داده واقعی:** تمام صفحات به جز Connections دارای empty state هستند.
- **Queue و Jobs:** هنوز پیاده‌سازی نشده.
