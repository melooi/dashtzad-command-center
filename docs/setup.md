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

## دستورهای مفید

```bash
php artisan test          # اجرای tests
npm run build             # build production assets
php artisan view:clear    # پاک کردن cache view‌ها
php artisan config:clear  # پاک کردن cache config
php artisan route:clear   # پاک کردن cache route‌ها
php artisan tinker        # Laravel REPL
```
