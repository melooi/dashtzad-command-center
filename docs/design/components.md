# Blade Components

مستندات کامپوننت‌های Blade موجود در پروژه.

---

## `layouts/app` — چیدمان اصلی

**مسیر:** `resources/views/components/layouts/app.blade.php`

**کاربرد:** wrapper اصلی همه صفحات پنل. تمام صفحات باید داخل این layout باشند.

```blade
<x-layouts.app>
    {{-- محتوای صفحه --}}
</x-layouts.app>
```

**شامل:**
- تگ `<html lang="fa" dir="rtl">`
- لود `resources/css/app.css` و `resources/js/app.js` از طریق Vite
- `<x-sidebar>`, `<x-header>`, `<x-activity-drawer>`
- `<main>` با padding responsive

**قوانین:**
- فقط یک بار در صفحه استفاده شود.
- هیچ CSS یا JS خارجی داخل آن اضافه نشود — همه asset‌ها از Vite می‌آیند.

---

## `sidebar` — ناوبری جانبی

**مسیر:** `resources/views/components/sidebar.blade.php`

**کاربرد:** ستون ناوبری سمت راست. عرض آن در موبایل `w-16` (icon-only) و در دسکتاپ `w-64` است.

**وابستگی JS:** `switchTab()` روی `window`

**قوانین:**
- ترتیب منوها را بدون دلیل تغییر نده.
- هر منو باید به یک `tab` مرتبط باشد که section متناظر آن در Command Center وجود داشته باشد.
- icon‌ها inline SVG هستند — از CDN یا کتابخانه خارجی استفاده نشود.

**نباید داخلش اضافه شود:**
- منطق JS
- فراخوانی API
- state management

---

## `header` — سربرگ بالای صفحه

**مسیر:** `resources/views/components/header.blade.php`

**کاربرد:** نوار بالای صفحه با جستجو، تاریخ، ناقوس اعلان، و avatar کاربر.

**وابستگی JS:** `toggleDrawer()` روی `window`

**قوانین:**
- ارتفاع ثابت `h-16` را تغییر نده.
- عنوان صفحه از `id="header-title"` توسط JS به‌روز می‌شود.

**وضعیت فعلی (Planned):**
- جستجو هنوز functional نیست.
- تاریخ جلالی هنوز محاسبه نمی‌شود (placeholder `—`).
- avatar و نام کاربر hard-coded هستند.

---

## `activity-drawer` — drawer تاریخچه

**مسیر:** `resources/views/components/activity-drawer.blade.php`

**کاربرد:** پانل کشویی سمت چپ برای نمایش تاریخچه فعالیت‌ها.

**وابستگی JS:** `toggleDrawer()` روی `window`

**رفتار:**
- باز/بسته شدن با تغییر class `translate-x-full`
- backdrop با `hidden-fade` / `visible-fade`
- کلیک روی backdrop آن را می‌بندد

**وضعیت فعلی (Planned):**
- محتوا empty state است — داده واقعی از backend می‌آید.

---

## `nav/item` — آیتم ناوبری تک‌سطحی

**مسیر:** `resources/views/components/nav/item.blade.php`

**کاربرد:** دکمه ناوبری بدون زیرمنو (مانند داشبورد، گزارش‌ها).

```blade
<x-nav.item tab="dashboard">
    <svg .../>
    <span class="mr-3 hidden md:block text-sm">داشبورد</span>
</x-nav.item>
```

**Props:**
- `tab` — شناسه tab برای `switchTab()`

**وابستگی JS:** `switchTab()` روی `window`

---

## `nav/group` — گروه ناوبری کشویی

**مسیر:** `resources/views/components/nav/group.blade.php`

**کاربرد:** بخش قابل بسط sidebar با زیرمنو (از `<details>` بومی استفاده می‌کند).

```blade
<x-nav.group title="محصولات" :open="true">
    <x-slot:icon><svg .../></x-slot:icon>
    <x-nav.subitem tab="products-list">همه محصولات</x-nav.subitem>
</x-nav.group>
```

**Props:**
- `title` — عنوان گروه
- `open` — باز بودن پیش‌فرض (boolean، پیش‌فرض false)

**Slots:**
- `icon` — SVG آیکون گروه
- `slot` — زیرمنوها (`<x-nav.subitem>`)

**نباید داخلش اضافه شود:**
- JS برای باز/بسته کردن (از `<details>` بومی استفاده می‌کند)
- آیتم‌های غیر از `<x-nav.subitem>`

---

## `nav/subitem` — زیرآیتم ناوبری

**مسیر:** `resources/views/components/nav/subitem.blade.php`

**کاربرد:** دکمه داخل یک `nav/group`.

```blade
<x-nav.subitem tab="tasks-list">کارهای امروز</x-nav.subitem>
```

**Props:**
- `tab` — شناسه tab برای `switchTab()`

**وابستگی JS:** `switchTab()` روی `window`

---

## `ui/empty-state` — وضعیت خالی

**مسیر:** `resources/views/components/ui/empty-state.blade.php`

**کاربرد:** نمایش placeholder برای بخش‌هایی که داده ندارند.

```blade
<x-ui.empty-state
    title="هنوز سفارشی ثبت نشده"
    description="اولین سفارش پس از اتصال WooCommerce اینجا نمایش داده می‌شود."
>
    <x-slot:icon><svg .../></x-slot:icon>
    <x-slot:action>
        <x-ui.btn>اتصال فروشگاه</x-ui.btn>
    </x-slot:action>
</x-ui.empty-state>
```

**Props:**
- `title` — عنوان کوتاه (پیش‌فرض: `موردی یافت نشد`)
- `description` — متن توضیحی (اختیاری)

**Slots:**
- `icon` — آیکون سفارشی (اختیاری، پیش‌فرض: inbox icon)
- `action` — دکمه CTA (اختیاری)
- `slot` — محتوای اضافی

**قوانین:**
- متن کوتاه و صادقانه باشد.
- اگر action واضح وجود ندارد، `action` slot اضافه نشود.

---

## `ui/stat-card` — کارت آماری

**مسیر:** `resources/views/components/ui/stat-card.blade.php`

**کاربرد:** نمایش یک metric در داشبورد.

```blade
<x-ui.stat-card value="۱۲۴" label="سفارش امروز" color="info" />
```

**Props:**
- `value` — مقدار نمایشی (پیش‌فرض: `۰`)
- `label` — برچسب زیر عدد
- `color` — `default` | `danger` | `warning` | `info` | `muted`

**نباید داخلش اضافه شود:**
- چند metric (هر کارت فقط یک مقدار)
- چارت یا گراف

---

## `ui/btn` — دکمه

**مسیر:** `resources/views/components/ui/btn.blade.php`

**کاربرد:** دکمه با استایل یکپارچه.

```blade
<x-ui.btn variant="primary" size="md" type="submit">ذخیره</x-ui.btn>
<x-ui.btn variant="danger">حذف</x-ui.btn>
```

**Props:**
- `variant` — `primary` | `secondary` | `ghost` | `danger` (پیش‌فرض: `primary`)
- `size` — `sm` | `md` | `lg` (پیش‌فرض: `md`)
- `type` — `button` | `submit` | `reset` (پیش‌فرض: `button`)

**نباید داخلش اضافه شود:**
- inline style
- رنگ دلخواه خارج از پالت تعریف‌شده
