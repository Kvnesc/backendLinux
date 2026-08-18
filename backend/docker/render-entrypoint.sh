#!/bin/sh
set -e

echo "=== Iniciando Backend LinuxPath en Render ==="

# Generar APP_KEY si no está definida
if [ -z "$APP_KEY" ]; then
    echo "Generando clave de aplicación..."
    php artisan key:generate --force
fi

# Asegurar existencia de SQLite
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_CONNECTION" ]; then
    mkdir -p database
    touch database/database.sqlite
fi

# Cachés de optimización
echo "Optimizando cachés de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migraciones y seeders
echo "Ejecutando migraciones y cargando datos semilla..."
php artisan migrate --force --seed

PORT="${PORT:-10000}"
echo "Servidor listo. Escuchando en el puerto $PORT..."

exec php artisan serve --host=0.0.0.0 --port="$PORT"
