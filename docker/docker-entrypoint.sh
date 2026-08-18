#!/bin/sh
set -e

echo "Ejecutando verificaciones de producción..."

# Esperar a que la base de datos o almacenamiento esté listo y ejecutar optimizaciones de Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force --seed

echo "Inicialización completada. Arrancando proceso..."
exec "$@"
