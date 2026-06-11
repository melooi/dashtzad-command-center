#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
PROJECT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"

echo "==> Deploy: $PROJECT_DIR"
cd "$PROJECT_DIR"

echo "==> git pull origin main"
git pull origin main

echo "==> composer install"
composer install --no-dev --optimize-autoloader

echo "==> npm"
if [ -f package-lock.json ]; then
    npm ci
else
    npm install
fi

echo "==> npm run build"
npm run build

echo "==> php artisan optimize:clear"
php artisan optimize:clear

echo "==> php artisan config:cache"
php artisan config:cache

echo "==> php artisan route:cache"
php artisan route:cache

echo "==> php artisan view:cache"
php artisan view:cache

echo "==> php artisan about"
php artisan about

echo "==> recent commits"
git log --oneline -3

echo "==> Deploy complete"
