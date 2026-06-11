# Security Policy

## مهم: Repository عمومی است

این repository public است. هیچ secret، credential، یا اطلاعات محرمانه‌ای نباید commit شود.

---

## قوانین اساسی

- فایل `.env` هرگز commit نشود — در `.gitignore` قرار دارد.
- API Key، Token، Password، و هر مقدار حساس فقط server-side و در `.env` نگهداری شود.
- هیچ credential واقعی در frontend code (JS، CSS، Blade) قرار نگیرد.
- هیچ credential واقعی در `localStorage` یا هیچ storage مرورگر ذخیره نشود.

---

## localStorage — قانون UI State

`localStorage` فقط برای وضعیت نمایشی UI مجاز است:

```json
{
  "serviceId": {
    "connected": true,
    "summaryLabel": "URL",
    "summaryValue": "https://example.com",
    "updatedAt": "ISO_DATE"
  }
}
```

**ممنوع برای ذخیره در localStorage:**

```
api_key, password, bot_token
consumer_key, consumer_secret
oauth_client_secret, refresh_token
service_account_json, webhook_secret
application_password
```

---

## ذخیره‌سازی Credentials (Planned)

در نسخه‌های آینده، credentials باید:
- در database ذخیره شوند (نه localStorage یا فایل)
- با `encrypt()` Laravel رمزنگاری شوند قبل از ذخیره
- فقط از طریق backend (PHP) رمزگشایی و استفاده شوند
- هرگز به frontend برگردانده نشوند

---

## Approval Gateway

action‌های حساس باید قبل از اجرا تأیید صریح کاربر را دریافت کنند:

- تغییر قیمت محصولات
- انتشار یا حذف محصول
- ارسال bulk SMS
- ایجاد یا تغییر coupon
- تغییر نقش یا دسترسی کاربران
- ایجاد، چرخش، یا حذف API key

---

## OTP و پیامک

- کد OTP فقط به صورت **hash‌شده** در database ذخیره شود — مقدار خام هرگز persist نشود.
- هر رکورد OTP باید شامل: expiry، شمارنده تلاش، rate limit ارسال مجدد، IP و user-agent باشد.

---

## Audit Log

تمام action‌های مهم باید audit log داشته باشند با حداقل:

- کاربر (user ID، نقش)
- action انجام‌شده
- منبع هدف
- timestamp
- IP address

Audit log نباید توسط کاربر عادی یا ادمین قابل حذف باشد.

---

## Authorization

- چک دسترسی سمت frontend فقط UI sugar است — هرگز جایگزین backend enforcement نمی‌شود.
- هر resource حساس باید Filament access policy داشته باشد.
- دسترسی‌ها باید server-side و قبل از هر action تأیید شوند.
