#!/bin/bash
set -e

echo "==> Generating .env from environment variables..."
cat > .env <<EOF
APP_NAME="Football Manager ORM"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=${DB_HOST:-mysql}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE:-football_manager}
DB_USERNAME=${DB_USERNAME:-dbuser}
DB_PASSWORD=${DB_PASSWORD:-changeme}

CACHE_STORE=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOF

echo "==> Generating application key..."
php artisan key:generate --force

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Seeding database (this may take a few minutes for ~14500 records)..."
php artisan db:seed --force

echo "==> Starting Laravel development server..."
exec php artisan serve --host=0.0.0.0 --port=8000
