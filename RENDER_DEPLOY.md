# Despliegue en Render.com (1-Click Blueprint) - LinuxPath API

Esta guía explica cómo desplegar la API backend de **LinuxPath** en [Render.com](https://render.com) en cuestión de minutos de forma gratuita o con planes de producción.

---

## Opción 1: Despliegue Automático mediante Render Blueprints (Recomendado)

1. Inicia sesión en tu cuenta de [Render.com](https://dashboard.render.com).
2. Haz clic en el botón **New +** (arriba a la derecha) y selecciona **Blueprint**.
3. Conecta tu repositorio de GitHub: `Kvnesc/backendLinux`.
4. Render detectará automáticamente el archivo [`render.yaml`](file:///c:/Users/ngrok/Downloads/LinuxPath/LinuxPath/render.yaml) presente en la raíz de tu proyecto.
5. Haz clic en **Apply**. Render creará el Web Service, compilará el contenedor Docker y desplegará la API.

---

## Opción 2: Creación Manual del Web Service

Si prefieres configurar el servicio manualmente en el Dashboard de Render:

1. Ve a **New +** -> **Web Service**.
2. Selecciona tu repositorio de GitHub: `Kvnesc/backendLinux`.
3. Ajusta los siguientes campos:
   - **Name:** `linuxpath-backend`
   - **Environment:** `Docker`
   - **Dockerfile Path:** `./backend/Dockerfile.render`
   - **Docker Build Context Path:** `./backend`
4. En **Environment Variables**, agrega las siguientes variables:
   - `APP_ENV`: `production`
   - `APP_DEBUG`: `false`
   - `DB_CONNECTION`: `sqlite`
   - `LOG_CHANNEL`: `stderr`
   - `APP_KEY`: *(Genera una clave con `php artisan key:generate --show` o deja que Render genere una)*.
5. Haz clic en **Create Web Service**.

---

## Verificación de tu API en Render

Una vez completado el despliegue (suele tardar de 2 a 3 minutos), Render te proporcionará una URL HTTPS pública (ejemplo: `https://linuxpath-backend.onrender.com`).

Prueba los siguientes enlaces en tu navegador:
- **Documentación Swagger UI:** `https://linuxpath-backend.onrender.com/docs/index.html`
- **Lista de Cursos API:** `https://linuxpath-backend.onrender.com/api/v1/courses` *(Requiere Bearer Token o puedes probar el registro/login desde Swagger)*.

---

## Conectar la App Android al Backend en Render

En tu proyecto Android, compila especificando la URL pública de Render:

```bash
cd android
./gradlew assembleRelease -PAPI_BASE_URL=https://linuxpath-backend.onrender.com/api/v1/
```
