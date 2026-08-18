# Guía de Despliegue a Producción - LinuxPath

Esta guía documenta la puesta en marcha en entorno de producción del ecosistema **LinuxPath** (Backend API + App Android Nativa).

---

## 1. Backend (Laravel 12 API con Docker y Swagger UI)

### Requisitos del Servidor
- Servidor VPS (Ubuntu 22.04 LTS o superior recomendado)
- Docker v24+ y Docker Compose v2.20+
- Nombre de Dominio apuntando al servidor con certificado SSL/TLS (HTTPS).

### Despliegue con Docker Compose

1. Clonar el repositorio en el servidor:
   ```bash
   git clone <URL_DEL_REPOSITORIO> linuxpath
   cd linuxpath/backend
   ```

2. Configurar el archivo de entorno de producción:
   ```bash
   cp .env.production.example .env
   ```
   *Edita `.env` asegurando un `APP_KEY` válido (generado con `php artisan key:generate --show`), las credenciales de MySQL (`DB_PASSWORD`) y `APP_URL=https://api.tudominio.com`.*

3. Iniciar los contenedores en segundo plano:
   ```bash
   docker compose up -d --build
   ```

4. Verificar que los 3 contenedores (`linuxpath_api`, `linuxpath_nginx`, `linuxpath_mysql`) estén ejecutándose:
   ```bash
   docker compose ps
   ```

### Certificado SSL (HTTPS con Certbot)
Se recomienda colocar Certbot o un Reverse Proxy como Nginx / Caddy frente a los contenedores:
```bash
sudo apt update && sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d api.tudominio.com
```

---

## 2. Pruebas Automatizadas en CI/CD

El proyecto cuenta con integración continua configurada mediante GitHub Actions:
- **Backend CI (`.github/workflows/backend-ci.yml`):** Ejecuta la validación del código y la suite de pruebas integrales en PHPUnit (`AuthTest`, `LessonAttemptTest`, `ProgressTest`).
- **Android CI (`.github/workflows/android-ci.yml`):** Compila la aplicación Android nativa para garantizar que no existan inconsistencias de compilación ni dependencias faltantes.

Para ejecutar los tests manualmente en desarrollo:
```bash
cd backend
php artisan test
```

---

## 3. App Móvil Android (Compilación de Release)

### Configuración del Dominio de Producción
En el archivo `android/gradle.properties` o mediante el parámetro Gradle `-PAPI_BASE_URL`, especifica la URL de producción con HTTPS:

```text
API_BASE_URL=https://api.tudominio.com/api/v1/
```

### Generación de APK/AAB Firmado para Google Play

1. Generar Keystore de firma en Android Studio o por terminal:
   ```bash
   keytool -genkey -v -keystore release.jks -alias linuxpath-key -keyalg RSA -keysize 2048 -validity 10000
   ```

2. Compilar la variante de Release minificada con Proguard:
   ```bash
   cd android
   ./gradlew assembleRelease -PAPI_BASE_URL=https://api.tudominio.com/api/v1/
   ```

3. El archivo APK resultante se ubicará en: `android/app/build/outputs/apk/release/app-release-unsigned.apk`.

---

## 4. Mantenimiento y Respaldos

### Respaldos de Base de Datos MySQL
Para crear un respaldo de la base de datos MySQL en producción:
```bash
docker exec linuxpath_mysql mysqldump -u linuxpath -psecret_password linuxpath > backup_$(date +%F).sql
```

### Monitoreo de Logs
Para ver los registros de la API en tiempo real:
```bash
docker compose logs -f app
```
