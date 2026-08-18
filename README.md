# 🚀 LinuxPath Backend API — Laravel 12

API RESTful desarrollada en **Laravel 12 (Estable)** para la plataforma educativa **LinuxPath**. Proporciona autenticación Bearer Token con Laravel Sanctum, gestión de cursos, módulos, lecciones, evaluación interactiva de comandos Linux/Bash y seguimiento del progreso del usuario.

---

## 🛠️ Stack Tecnológico

- **Framework:** Laravel 12 (PHP 8.2+)
- **Autenticación:** Laravel Sanctum (Bearer Token)
- **Documentación API:** OpenAPI 3.0 & **Swagger UI** interactivo (`/docs/index.html`)
- **Base de Datos:** SQLite (desarrollo/PaaS) / MySQL 8.0 (producción VPS)
- **Contenedores & PaaS:** Docker, Docker Compose y **Render.com** (1-Click Blueprint)

---

## 📚 Documentación Interactiva de la API (Swagger UI)

La API cuenta con especificación OpenAPI 3.0 completa para todos sus endpoints (`/api/v1`).

Al levantar el servidor, accede en tu navegador a:
👉 **`http://localhost:8000/docs/index.html`**

O consulta el esquema JSON crudo en:
👉 **`http://localhost:8000/swagger.json`**

### Endpoints Disponibles (`/api/v1`)

```text
POST /api/v1/auth/register          - Registro de usuario
POST /api/v1/auth/login             - Inicio de sesión
POST /api/v1/auth/logout            - Cerrar sesión (Bearer Token)
GET  /api/v1/me                     - Perfil de usuario (Bearer Token)
GET  /api/v1/courses                - Lista de cursos
GET  /api/v1/courses/{slug}         - Detalle de curso y módulos
GET  /api/v1/lessons/{id}           - Lección y ejercicios de comandos
POST /api/v1/lessons/{id}/complete    - Marcar lección completada
POST /api/v1/exercises/{id}/attempt   - Evaluar comando Linux enviado
GET  /api/v1/progress               - Porcentaje de avance por curso
```

---

## ⚡ Inicio Rápido en Desarrollo Local

```bash
cp .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8000
```

### Cuenta de Demostración
```text
Email:    demo@linuxpath.local
Password: password
```

---

## ☁️ Despliegue en la Nube

### Opción A: Render.com (1-Click Blueprint — Recomendado)

Este repositorio contiene la configuración nativa `render.yaml` y `Dockerfile.render` para despliegue en Render.com:

1. Ingresa a [dashboard.render.com](https://dashboard.render.com).
2. Haz clic en **New +** ➡️ **Blueprint**.
3. Conecta el repositorio GitHub: `Kvnesc/backendLinux`.
4. Haz clic en **Apply**.

Render compilará el contenedor Docker y proporcionará una URL HTTPS pública en 2 minutos.

### Opción B: Servidor VPS (Ubuntu 24.04 / Debian 12 con Docker Compose)

1. Clonar el repositorio en el servidor VPS:
   ```bash
   git clone https://github.com/Kvnesc/backendLinux.git linuxpath-api
   cd linuxpath-api
   cp .env.production.example .env
   ```
2. Editar `.env` configurando `APP_URL`, `DB_PASSWORD` y la clave `APP_KEY`.
3. Levantar la pila completa (Laravel FPM + Nginx + MySQL 8.0):
   ```bash
   docker compose up -d --build
   ```
4. Configurar SSL/HTTPS gratis con Certbot:
   ```bash
   sudo certbot --nginx -d api.tudominio.com
   ```

---

## 🧪 Pruebas Automatizadas

Ejecuta la suite de pruebas integrales (Auth, Lecciones, Intentos de comandos y Progreso):

```bash
php artisan test
```
