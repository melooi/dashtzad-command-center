# Connections Page

صفحه مدیریت اتصالات و API Keys سرویس‌های خارجی.

---

## فایل‌ها

| نوع | مسیر |
|-----|------|
| Blade | `resources/views/command-center/sections/connections.blade.php` |
| JS | `resources/js/app.js` (بخش connections) |

---

## وضعیت پیاده‌سازی

**Frontend-only** — هیچ backend، migration، یا API call واقعی وجود ندارد. وضعیت اتصال در `localStorage` ذخیره می‌شود.

---

## گروه‌های کارت

| گروه | رنگ accent | `id` container |
|------|-----------|----------------|
| مدل‌های AI | indigo | `group-ai` |
| سایت و فروشگاه | pink | `group-site` |
| پیامک | amber | `group-sms` |
| سرویس‌های گوگل | blue | `group-google` |
| پیام‌رسان‌ها | emerald | `group-messengers` |

---

## سرویس‌های فعلی

| سرویس | گروه | `summaryLabel` |
|-------|------|----------------|
| OpenAI | ai | Model |
| Claude | ai | Model |
| Gemini | ai | Model |
| WordPress | site | URL |
| WooCommerce | site | URL |
| MSGway | sms | Provider |
| Google Custom Search | google | CX |
| Google Search Console | google | URL |
| Google Analytics | google | Property ID |
| Google Sheets | google | Sheet ID |
| Telegram Bot | messengers | Bot |
| Bale Bot | messengers | Bot |
| SMTP Email | messengers | Host |

---

## قانون امنیتی localStorage

**هیچ credential واقعی نباید در `localStorage` ذخیره شود.**

### فیلدهای ممنوع برای ذخیره‌سازی

```
api_key
password
bot_token
consumer_key
consumer_secret
oauth_client_secret
refresh_token
service_account_json
webhook_secret
application_password
```

### ساختار مجاز

```json
{
  "serviceId": {
    "connected": true,
    "summaryLabel": "URL",
    "summaryValue": "https://example.com",
    "updatedAt": "2026-06-11T00:00:00.000Z"
  }
}
```

- `summaryValue` فقط از فیلدهای غیرحساس (url، text، number) گرفته می‌شود.
- اگر فقط فیلد secret پر شود، `summaryValue` برابر `'ذخیره شده'` ذخیره می‌شود.
- `connected: true` نشان‌دهنده وجود credentials در backend آینده است، نه در مرورگر.

---

## رفتار Save

1. کاربر مودال را باز می‌کند.
2. حداقل یک فیلد (از هر نوع) را پر می‌کند.
3. دکمه «ذخیره تغییرات» را می‌فشارد.
4. اگر هر فیلدی مقدار داشت → `connected: true` ذخیره می‌شود.
5. فقط مقدار اولین فیلد غیرحساس به عنوان `summaryValue` ذخیره می‌شود.
6. فیلدهای `secret` و `textarea_secret` از DOM پاک می‌شوند.
7. کارت re-render می‌شود.

---

## رفتار Disconnect

- دکمه disconnect فقط state نمایشی همان سرویس را از `localStorage` حذف می‌کند.
- سایر سرویس‌ها دست‌نخورده می‌مانند.
- امضای تابع: `disconnectService(id, event = null)`

---

## اضافه کردن سرویس جدید

برای اضافه کردن سرویس جدید به `connectionServices` در `app.js`:

1. شیء سرویس را به آرایه `connectionServices` اضافه کن (با `connected: false`).
2. فیلدهای مودال را در `connectionServiceFields` تعریف کن.
3. فیلدهای sensitive باید `type: 'secret'` یا `type: 'textarea_secret'` داشته باشند.
4. `group` را با یکی از پنج گروه موجود هماهنگ کن.

---

## Planned

- ذخیره‌سازی credentials رمزنگاری‌شده در database (backend)
- validation فیلدها قبل از save
- تست اتصال live (ping API)
- نمایش وضعیت سرویس (quota، expiry)
