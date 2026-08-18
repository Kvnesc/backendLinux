# LinuxPath

Aplicación Android nativa para aprender Linux desde cero hasta un nivel profesional, con backend API en Laravel 12.

## Stack elegido

### Android
- Kotlin 2.3.20
- Android Views/XML (sin Compose para reducir dependencias y tamaño)
- AppCompat
- RecyclerView
- Lifecycle / coroutines
- Retrofit 3 + Gson
- SharedPreferences para el token (sin DataStore/Hilt/Room para mantener el cliente ligero)
- compileSdk 36 / targetSdk 36 / minSdk 23

### Backend
- **Laravel 12** (versión estable de producción actual)
- Documentación OpenAPI 3.0 & **Swagger UI** interactivo en `/docs`
- Laravel Sanctum para autenticación móvil por Bearer Token
- Eloquent ORM
- SQLite por defecto
- MySQL listo para activarse cambiando solamente `.env`

## Funciones incluidas

- Registro e inicio de sesión.
- Ruta de aprendizaje ordenada por nivel.
- Cursos, módulos y lecciones.
- Ejercicios de comandos Linux/Bash.
- Validación de respuestas en el backend.
- Progreso por lección y curso.
- Documentación OpenAPI 3.0 & Swagger UI.
- API versionada en `/api/v1`.

## Estructura

```text
LinuxPath/
├── android/    # App Android Kotlin
└── backend/    # API Laravel 12 con Swagger UI
```

## Inicio rápido del backend

```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8000
```

Cuenta de demostración creada por el seeder:

```text
email: demo@linuxpath.local
password: password
```

## Android

Abre `android/` con Android Studio.

El emulador Android usa por defecto:

```text
http://10.0.2.2:8000/api/v1/
```

Para un teléfono físico usa la IP LAN de tu servidor. Puedes fijarla en Android Studio como propiedad Gradle `API_BASE_URL`, por ejemplo:

```text
http://192.168.1.50:8000/api/v1/
```

Para producción usa una URL HTTPS, por ejemplo:

```text
https://api.tudominio.cl/api/v1/
```

El proyecto incluye `gradle-wrapper.properties`, pero no distribuye `gradle-wrapper.jar` ni binarios de terceros. Android Studio puede sincronizar el proyecto usando Gradle 8.13. Si quieres compilar exclusivamente desde terminal, genera una vez el wrapper desde una instalación local de Gradle:

```bash
cd android
gradle wrapper --gradle-version 8.13
./gradlew assembleDebug -PAPI_BASE_URL=http://192.168.1.50:8000/api/v1/
```

## Cambiar SQLite a MySQL

No debes cambiar controladores, modelos ni repositorios. Solo el `.env` del backend.

SQLite:

```env
DB_CONNECTION=sqlite
# DB_DATABASE=/ruta/absoluta/al/proyecto/database/database.sqlite
```

MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=linuxpath
DB_USERNAME=linuxpath
DB_PASSWORD=tu_clave
```

Luego ejecuta:

```bash
php artisan config:clear
php artisan migrate
```

Si vas a mover datos existentes desde SQLite a MySQL, la estructura ya es portable, pero debes migrar los datos con un dump/script ETL; cambiar el `.env` no copia automáticamente los registros.
