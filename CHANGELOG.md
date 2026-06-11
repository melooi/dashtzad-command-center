# Changelog

تاریخ‌ها به تقویم شمسی — فرمت: `[vX.Y.Z] - YYYY/MM/DD`

---

## [Unreleased]

---

## [v0.2.0] - 1405/03/21

### Added
- صفحه «افزودن سریع محصولات» در مسیر `/products/quick-create`
- جدول شیت‌مانند با ۱۲ ستون و ناوبری کیبورد (فلش، Tab، Enter، Ctrl+D، Delete، Escape)
- بررسی و نمایش نواقص هر ردیف به‌صورت realtime با progress bar
- مودال ویرایش جامع با ۶ تب: محتوا، قیمت‌گذاری، رسانه، انبار، سئو، تاریخچه محصول
- مودال ایجاد تسک برای هر ردیف یا فیلد
- پشتیبانی از paste چندستونه و چندردیفه از Excel
- آیتم Sidebar برای دسترسی سریع به صفحه

### Fixed
- نقشه‌بندی اشتباه ایندکس ستون‌ها در `checkCompleteness` (قیمت فروش و موجودی)
- حالت فعال تب «سئو» در مودال ویرایش
- تصویر از فیلدهای اجباری حذف شد (همیشه ناقص بود — UX مشکل‌دار)

---

## [v0.1.1] - 1405/03/21

### Added
- صفحه «گزارش آپدیت‌ها» در مسیر `/changelog`
- خواندن و parse کردن `CHANGELOG.md` توسط `ChangelogController`
- نمایش کارت‌محور نسخه‌ها با Badge رنگی برای هر نوع تغییر
- آیتم Sidebar برای دسترسی سریع به گزارش آپدیت‌ها
- نمایش پیام مناسب در صورت نبود فایل `CHANGELOG.md`

---

## [v0.1.0] - 1405/03/21

### Added
- Sidebar جمع‌شونده در دسکتاپ با انیمیشن ۲۵۰ms
- Mobile Drawer از سمت راست با overlay و scroll lock
- ذخیره وضعیت Sidebar در localStorage و بازیابی هنگام reload
- Hamburger در Header برای موبایل
- Tooltip روی آیکون‌های Sidebar در حالت جمع‌شده

### Fixed
- مخفی شدن Chevron در حالت جمع‌شده Sidebar

### Security
- اصلاح `saveConnectionsModal()`: مقادیر sensitive (api_key, token, secret) هرگز در localStorage ذخیره نمی‌شوند
- فیلدهای sensitive پس از save از DOM پاک می‌شوند
- تنها `summaryValue` از فیلد غیرحساس ذخیره می‌شود

### Docs
- به‌روزرسانی `README.md`, `ROADMAP.md`, `SECURITY.md`
- بازنویسی `docs/architecture.md`, `docs/mvp-scope.md`, `docs/setup.md`
- ایجاد `docs/design/` شامل design-system, ui-rules, components, connections-page
