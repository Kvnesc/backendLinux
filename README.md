# LinuxPath Backend API — Laravel 12

API RESTful desarrollada en **Laravel 12 (Estable)** para la plataforma de aprendizaje **LinuxPath**.

---

## ⚡ Stack Tecnológico

- **Framework:** Laravel 12
- **Autenticación:** Laravel Sanctum (Bearer Token)
- **Documentación API:** OpenAPI 3.0 & **Swagger UI** interactivo en `/docs`
- **Base de Datos:** SQLite (por defecto en dev/PaaS) / MySQL 8.0 (con Docker Compose)
- **Despliegue Cloud:** Docker / Render.com (`render.yaml`) / Nginx + FPM

---

## 🚀 Inicio Rápido en Desarrollo Local

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

## 📚 Documentación Interactiva Swagger UI

Al iniciar el servidor, accede en el navegador a:

👉 **`http://localhost:8000/docs/index.html`**

O consulta el esquema OpenAPI 3.0 JSON en:

👉 **`http://localhost:8000/swagger.json`**

---

## 🌐 Despliegue en Render.com (1-Click)

Este repositorio incluye soporte nativo para **Render Blueprints**:
1. Conecta este repositorio en [Render.com](https://render.com).
2. Render utilizará automaticamente [`render.yaml`](file:///c:/Users/ngrok/Downloads/LinuxPath/LinuxPath/render.yaml) y [`Dockerfile.render`](file:///c:/Users/ngrok/Downloads/LinuxPath/LinuxPath/Dockerfile.render).

Para instrucciones detalladas consulta la guía [`RENDER_DEPLOY.md`](file:///c:/Users/ngrok/Downloads/LinuxPath/LinuxPath/RENDER_DEPLOY.md).

---

## 🧪 Pruebas Automatizadas

```bash
php artisan test
```
