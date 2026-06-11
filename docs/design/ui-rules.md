# UI Rules

قوانین الزامی برای توسعه رابط کاربری پنل فرماندهی دشت‌زاد.

---

## قوانین کلی

- هیچ تغییر ظاهری بزرگ (رنگ، فونت، چیدمان) بدون تأیید صریح اعمال نشود.
- Sidebar و Header مرجع اصلی UI هستند؛ ساختار آن‌ها بدون دلیل تغییر نکند.
- UI نباید شبیه CRUD خام شود — هر صفحه باید ظاهر هدفمند داشته باشد.
- هیچ فونت جدید یا CDN خارجی بدون تأیید اضافه نشود.

---

## ساختار صفحات

- هر منوی sidebar باید یک section مستقل داشته باشد.
- هر section باید در یک `<div id="page-xxx" class="hidden ...">` قرار بگیرد.
- `id` صفحه باید دقیقاً با مقدار `tab` در `switchTab()` هماهنگ باشد.
- صفحات در `resources/views/command-center/sections/` نگهداری می‌شوند.

---

## JS و Blade

- توابع فراخوانی‌شده از `onclick` در Blade **باید** روی `window` ثبت شوند:

```javascript
window.myFunction = myFunction; // الزامی — Vite module scope را ایزوله می‌کند
```

- ثبت روی `window` باید در انتهای `resources/js/app.js` باشد.
- هرگز تابعی را به‌صورت global در Blade با `<script>` تعریف نکنید.

---

## RTL و زبان

- تمام فرم‌ها، منوها و متن‌های فارسی باید `dir="rtl"` داشته باشند (از HTML ارث می‌برند).
- مقادیر انگلیسی (API Key، URL، Model، Token، کدها) باید `dir="ltr"` داشته باشند.
- placeholder فیلدهای فارسی باید فارسی باشد.

---

## Empty State

- هر صفحه‌ای که ممکن است بدون داده باشد باید empty state داشته باشد.
- از کامپوننت `<x-ui.empty-state>` استفاده شود.
- متن empty state کوتاه، صادقانه، و متناسب با context صفحه باشد.
- دکمه action در empty state اختیاری است — فقط اگر action واضح وجود داشت اضافه شود.

---

## رنگ و استایل

- تمام رنگ‌های جدید از پالت موجود (slate / indigo / emerald / rose / amber / blue) انتخاب شوند.
- کارت‌ها باید `bg-slate-900 border border-slate-800 rounded-2xl` داشته باشند.
- hover transition باید نرم باشد (`transition-all` یا `transition-colors`).
- از shadow‌های خیلی پررنگ خودداری شود.

---

## مودال‌ها و Drawer

- باز/بسته شدن مودال از `hidden-fade` / `visible-fade` و `openModal()` / `closeModal()` استفاده کند.
- backdrop باید قابل کلیک برای بستن باشد.
- مودال روی `z-50` و drawer روی `z-40` قرار بگیرند.
- فیلدهای sensitive (password, token) نباید pre-fill شوند.
