# Design System

پنل فرماندهی دشت‌زاد از یک design system تیره، RTL، و فارسی‌محور استفاده می‌کند.

---

## فونت

- **فونت اصلی:** IRANYekanX (self-hosted، بدون CDN)
- فایل‌ها در `public/fonts/` قرار دارند و از طریق `resources/css/app.css` لود می‌شوند
- از `font-display: swap` استفاده شده

---

## جهت و زبان

- **جهت:** RTL (`dir="rtl"` روی `<html>`)
- **زبان:** فارسی (`lang="fa"`)
- مقادیر انگلیسی (URL، API Key، کد، تاریخ ISO) باید `dir="ltr"` داشته باشند

---

## رویکرد طراحی

- **Dark-first:** پس‌زمینه اصلی `slate-950`، کارت‌ها `slate-900`
- رنگ‌های روشن فقط برای تأکید و وضعیت استفاده می‌شوند
- هیچ تم روشن (light mode) وجود ندارد

---

## رنگ‌ها

| نقش | رنگ Tailwind | کاربرد |
|-----|-------------|---------|
| پس‌زمینه اصلی | `slate-950` | body، header |
| پس‌زمینه کارت | `slate-900` | کارت‌ها، sidebar |
| خطوط جداکننده | `slate-800` | border بین عناصر |
| متن اصلی | `slate-200` | عنوان‌ها |
| متن فرعی | `slate-400` | توضیحات |
| متن خاموش | `slate-500` | placeholder |
| تأکید اصلی | `indigo-500/600` | دکمه primary، active state |
| موفقیت | `emerald-500` | connected، success |
| خطر | `rose-500` | disconnect، danger |
| هشدار | `amber-500` | warning |
| اطلاعات | `blue-500` | info، Google |
| سفارشی | `--color-slate-850: #151e2e` | footer modal |

---

## ساختار کلی صفحه

```
<html dir="rtl">
  <body class="bg-slate-950 flex h-screen overflow-hidden">
    <x-sidebar />                 ← عرض ثابت، RTL (سمت راست)
    <div class="flex-1 flex flex-col">
      <x-header />                ← ارتفاع ۶۴px، sticky
      <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
        {{ $slot }}               ← محتوای هر صفحه
      </main>
    </div>
    <x-activity-drawer />         ← drawer سمت چپ
  </body>
</html>
```

---

## کارت‌ها

```css
bg-slate-900
border border-slate-800
rounded-2xl
p-5
transition-all shadow-sm
```

**hover:**
```css
hover:border-indigo-500/40
hover:shadow-indigo-900/10
```

**کارت کلیک‌پذیر (`.clickable-card`):**
- cursor pointer
- عنوان (`card-title`) روی hover به `indigo-400` تغییر رنگ می‌دهد

---

## دکمه‌ها

| نوع | رنگ |
|-----|-----|
| Primary | `bg-indigo-600 hover:bg-indigo-500 text-white` |
| Secondary | `bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700` |
| Ghost | `text-slate-400 hover:text-white hover:bg-slate-800` |
| Danger | `bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20` |

---

## مودال‌ها

**باز شدن:** `hidden-fade` → `visible-fade` (CSS transition)
**backdrop:** `bg-black/60 backdrop-blur-sm fixed inset-0 z-50`
**پنل:** `bg-slate-900 border border-slate-800 rounded-2xl max-w-lg shadow-2xl`
**انیمیشن:** `scale-95` حذف می‌شود با `requestAnimationFrame`

---

## Spacing

- padding صفحه: `p-4 md:p-6 lg:p-8`
- فاصله بین section‌ها: `space-y-12`
- فاصله بین کارت‌ها: `gap-5`
- padding کارت: `p-5`
- padding مودال: `p-5` (header/footer)، `p-6` (body)
