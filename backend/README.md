# LinuxPath API — Laravel 12

## Requisitos
- PHP 8.2+
- Composer
- extensión PDO SQLite para desarrollo
- extensión PDO MySQL cuando uses MySQL

## Desarrollo con SQLite

```bash
cp .env.example .env
composer install
php artisan key:generate
mkdir -p database
touch database/database.sqlite
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8000
```

La configuración incluida usa `database/database.sqlite` como valor por defecto interno. Si defines `DB_DATABASE` explícitamente, usa una ruta absoluta para SQLite.

## Documentación API Interactivas con Swagger UI

La API está completamente documentada con la especificación OpenAPI 3.0. Puedes acceder a la consola interactiva **Swagger UI** iniciando el servidor y navegando a:

👉 **`http://localhost:8000/docs/index.html`**

O inspeccionar el esquema JSON crudo en:

👉 **`http://localhost:8000/swagger.json`**

## Endpoints Disponibles `/api/v1`

```text
POST /api/v1/auth/register
POST /api/v1/auth/login
POST /api/v1/auth/logout
GET  /api/v1/me
GET  /api/v1/courses
GET  /api/v1/courses/{slug}
GET  /api/v1/lessons/{id}
POST /api/v1/lessons/{id}/complete
POST /api/v1/exercises/{id}/attempt
GET  /api/v1/progress
```

Las rutas privadas requieren el encabezado:

```http
Authorization: Bearer TU_TOKEN
Accept: application/json
```
