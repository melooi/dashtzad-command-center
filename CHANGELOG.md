# Changelog

تاریخ‌ها به تقویم شمسی — فرمت: `[vX.Y.Z] - YYYY/MM/DD`

---

## [Unreleased]

---

## [v0.2.4] - 1405/03/21

### Added
- طول OTP قابل تنظیم از طریق `PANEL_OTP_LENGTH` در `.env` (پیش‌فرض ۴ رقم)
- `config/panel.php`: تنظیمات مرکزی پنل (`otp_length`، `admin_phone`)
- Auto-submit OTP: به محض پر شدن همه باکس‌ها، verify خودکار انجام می‌شود

### Fixed
- MSGway: کد OTP تولیدشده توسط Laravel در فیلد `code` ارسال می‌شود (نه `params`) — جلوگیری از تولید کد توسط MSGway
- Admin bootstrap: اگر کاربر ادمین با وضعیت `pending_approval` در DB بود، در `verifyOtp` خودکار `super_admin` می‌شود
- `PANEL_ADMIN_PHONE` از `config('panel.admin_phone')` خوانده می‌شود (نه `env()` مستقیم) — رفع باگ با config cache
- Layout ورود: کارت در همه سایزها وسط‌چین شد (حذف bottom-sheet موبایل)
- فرم پروفایل: فیلدهای «دلیل دسترسی» و «معرف» حذف شدند

---

## [v0.2.2] - 1405/03/21

### Added
- سیستم احراز هویت پنل: ورود با شماره موبایل + کد OTP پنج‌رقمی
- جریان ورود: شماره → OTP → تکمیل پروفایل → انتظار تأیید → داشبورد
- وضعیت‌های کاربر: `pending_profile` / `pending_approval` / `approved` / `rejected` / `blocked`
- لاگ ورودها با ذخیره IP، User-Agent، وضعیت و تعداد تلاش‌های ناموفق
- Bootstrap ادمین: با تنظیم `PANEL_ADMIN_PHONE` در `.env`، اولین ورود `super_admin` می‌شود
- مدیریت کاربران در تنظیمات: تأیید، رد، مسدودسازی، تغییر نقش
- نقش‌های کاربری: `super_admin`، `project_manager`، `product_specialist`، `content_specialist`، `seo_specialist`، `sales_specialist`، `viewer`
- `SmsService`: در local کد OTP در UI نمایش داده می‌شود؛ در production از MSGway استفاده می‌شود
- محدودیت ۳ تلاش برای هر OTP، تایمر ارسال مجدد ۲ دقیقه‌ای، rate limit سه درخواست در ۱۰ دقیقه

### Changed
- تاریخ هدر: فرمت `چهارشنبه ۲۱ خرداد | ۱۵:۴۲` با جداسازی هر بخش
- PJAX: پاسخ ۴۰۱ به صفحه ورود ریدایرکت می‌کند
- تم برند: نوار PJAX، `sheet-input:focus` و `card-title:hover` به `brand-primary/secondary` تبدیل شدند

### Fixed
- نمایش `—` به‌جای تاریخ واقعی در هدر در برخی مرورگرها
- `PanelAuth`: اگر جدول `app_settings` هنوز وجود نداشت، سرور crash نمی‌کرد

---

## [v0.2.1] - 1405/03/21

### Added
- تسک‌منیجر: لیست وظایف با متریک‌های ۵گانه، فیلتر، و quick-add
- تسک‌منیجر: کانبان بورد ۶ستونه با drag-drop کامل
- تسک‌منیجر: مودال جزئیات ۳ستونه (متا / محتوا / چت+لاگ+AI)
- دستیار AI در مودال تسک با شبیه‌ساز streaming
- سیستم رنگ برند: توکن‌های `brand-primary` (#315A3A) تا `brand-neutral` در Tailwind v4 `@theme`
- دارک‌مود/لایت‌مود با `@custom-variant dark` — ذخیره در localStorage، بدون flash
- دکمه تغییر تم (آفتاب/ماه) در هدر

### Changed
- لوگو Sidebar: از `bg-indigo-600` به `bg-brand-primary`
- حالت active ناوبری: از indigo به `brand-primary`
- آواتار کاربر هدر: از indigo به brand-primary
- nav item/subitem/group: hover رنگ به `text-slate-200` (در هر دو تم)
- Kanban drag-over رنگ: از indigo به brand-primary

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
- جایگزینی همه آیکون‌های SVG پروژه با Font Awesome 6.5.1 (۴۳ فایل)
- PJAX router با History API برای ناوبری بدون reload بین تب‌ها و صفحات مستقل
- نوار بارگذاری PJAX در بالای صفحه با انیمیشن
- نمایش تاریخ جلالی و ساعت ایران در هدر (`Asia/Tehran`، اعداد فارسی)
- Deploy خودکار به سرور production از طریق GitHub Actions

### Fixed
- نقشه‌بندی اشتباه ایندکس ستون‌ها در `checkCompleteness` (قیمت فروش و موجودی)
- حالت فعال تب «سئو» در مودال ویرایش
- تصویر از فیلدهای اجباری حذف شد (همیشه ناقص بود — UX مشکل‌دار)
- کلیک روی آیتم‌های Sidebar در صفحات مستقل دیگر بی‌اثر نمی‌ماند
- دکمه Back/Forward مرورگر history را خراب نمی‌کند

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
