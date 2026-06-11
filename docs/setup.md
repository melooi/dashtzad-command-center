# Setup Guide

## پیش‌نیازها

| ابزار | نسخه |
|------|------|
| PHP | 8.3+ (production: 8.4) |
| Composer | 2.x |
| MariaDB | — |
| Node.js | 20+ |
| npm | 10+ |

---

## نصب محلی

```bash
git clone https://github.com/melooi/dashtzad-command-center.git
cd dashtzad-command-center

composer install

cp .env.example .env
php artisan key:generate

# مقادیر DB را در .env تنظیم کن:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_DATABASE=dashtzad
# DB_USERNAME=...
# DB_PASSWORD=...

php artisan migrate

npm install
npm run dev

php artisan serve
```

آدرس محلی: `http://localhost:8000`

---

## متغیرهای `.env` مهم

```dotenv
APP_NAME="Dashtzad Command Center"
APP_ENV=local          # production روی سرور
APP_KEY=               # با artisan key:generate ساخته می‌شود
APP_DEBUG=true         # false در production
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dashtzad
DB_USERNAME=your_user
DB_PASSWORD=your_password

QUEUE_CONNECTION=sync  # database یا redis در production
```

---

## نصب روی VPS (Ubuntu)

```bash
# پیش‌نیازهای سیستم
sudo apt update
sudo apt install -y php8.4 php8.4-fpm php8.4-cli php8.4-mbstring php8.4-xml \
    php8.4-bcmath php8.4-curl php8.4-zip php8.4-mysql \
    mariadb-server nginx git curl unzip nodejs npm

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Clone و نصب
git clone https://github.com/melooi/dashtzad-command-center.git /var/www/dashtzad
cd /var/www/dashtzad

composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
# .env را ویرایش کن

php artisan migrate --force
npm install
npm run build

php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

sudo chown -R www-data:www-data storage bootstrap/cache
```

---

## پیکربندی Nginx

```nginx
server {
    listen 80;
    server_name tools.dashtzad.com;
    root /var/www/dashtzad/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

---

## SSL با Certbot

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d tools.dashtzad.com
```

---

## Deploy از GitHub

```bash
cd /var/www/dashtzad
git pull origin main
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Auto Deploy

هر push به `main` یک GitHub Actions workflow اجرا می‌کند که از طریق SSH به سرور وصل می‌شود و `scripts/deploy.sh` را اجرا می‌کند.

### ۱. ساخت SSH Key

این key را روی ماشین محلی بساز — **نه** روی سرور:

```bash
ssh-keygen -t ed25519 -C "github-actions-deploy" -f ~/.ssh/dashtzad_deploy -N ""
```

دو فایل ساخته می‌شود:
- `~/.ssh/dashtzad_deploy` — کلید خصوصی (در GitHub Secrets ثبت می‌شود)
- `~/.ssh/dashtzad_deploy.pub` — کلید عمومی (روی سرور اضافه می‌شود)

### ۲. افزودن Public Key به سرور

```bash
# کلید عمومی را کپی کن:
cat ~/.ssh/dashtzad_deploy.pub

# روی سرور (با دسترسی SSH فعلی):
ssh user@89.45.89.203
echo "PASTE_PUBLIC_KEY_HERE" >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

### ۳. ثبت Secrets در GitHub

مسیر: **GitHub → Repository → Settings → Secrets and variables → Actions → New repository secret**

| Secret | مقدار |
|--------|-------|
| `SSH_HOST` | `89.45.89.203` |
| `SSH_USER` | نام کاربر روی سرور (مثلاً `deploy`) |
| `SSH_PORT` | `22` (یا port سفارشی) |
| `SSH_PRIVATE_KEY` | محتوای کامل `~/.ssh/dashtzad_deploy` |
| `APP_PATH` | `/var/www/dashtzad-command-center` |

### ۴. آماده‌سازی سرور

```bash
# اطمینان از اینکه deploy user می‌تواند git pull کند:
cd /var/www/dashtzad-command-center
git remote -v
git fetch origin main

# مطمئن شو که www-data یا nginx به فایل‌ها دسترسی دارد:
sudo chown -R deploy:www-data /var/www/dashtzad-command-center
sudo chmod -R 775 storage bootstrap/cache
```

### ۵. تست Deploy

```bash
# از terminal محلی، SSH را دستی امتحان کن:
ssh -i ~/.ssh/dashtzad_deploy -p 22 user@89.45.89.203 \
  "bash /var/www/dashtzad-command-center/scripts/deploy.sh"

# یا یک push به main بزن و نتیجه را در GitHub → Actions ببین
```

---

## دستورهای مفید

```bash
php artisan test          # اجرای tests
npm run build             # build production assets
php artisan view:clear    # پاک کردن cache view‌ها
php artisan config:clear  # پاک کردن cache config
php artisan route:clear   # پاک کردن cache route‌ها
php artisan tinker        # Laravel REPL
```
