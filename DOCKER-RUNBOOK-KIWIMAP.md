# DOCKER RUNBOOK — Kiwimap (Laravel 12 + PHP 8.2 + MySQL + Vite/Tailwind)

## 0) Objetivo
Reemplazar XAMPP con Docker para correr **Kiwimap** localmente:

- PHP 8.2 (contenedor `app`)
- Nginx (contenedor `web`)
- MySQL (contenedor `db`)
- phpMyAdmin (contenedor `phpmyadmin`)
- Node/Vite para Tailwind (contenedor `vite`)

---

## 1) Archivos que deben existir (en la raíz del proyecto)
Estructura mínima:

```
Kiwimap/
  artisan
  composer.json
  package.json
  docker-compose.yml
  Dockerfile
  docker/
    nginx/
      default.conf
```

---

## 2) Imágenes (lo que necesitas)
Docker las descarga automáticamente al levantar el stack, pero estas son las imágenes que usa el proyecto:

- `php:8.2-fpm` (runtime Laravel)
- `nginx:alpine` (servidor web)
- `mysql:8.0` (DB)
- `phpmyadmin/phpmyadmin:latest` (admin DB)
- `node:20-alpine` (Vite/Tailwind)

> Nota: PHP 8.3 se usa en futuras apps o cuando decidas migrar.

---

## 3) docker-compose.yml (stack completo)
Archivo en la raíz: `docker-compose.yml`

```yaml
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: kiwimap_app
    working_dir: /var/www
    volumes:
      - ./:/var/www
    depends_on:
      - db

  web:
    image: nginx:alpine
    container_name: kiwimap_web
    ports:
      - "8080:80"
    volumes:
      - ./:/var/www
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - app

  db:
    image: mysql:8.0
    container_name: kiwimap_db
    environment:
      MYSQL_DATABASE: kiwimap
      MYSQL_USER: kiwimap
      MYSQL_PASSWORD: kiwimap
      MYSQL_ROOT_PASSWORD: root
    ports:
      - "3307:3306"
    volumes:
      - dbdata:/var/lib/mysql

  phpmyadmin:
    image: phpmyadmin/phpmyadmin:latest
    container_name: kiwimap_pma
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      MYSQL_ROOT_PASSWORD: root
    ports:
      - "8081:80"
    depends_on:
      - db

  vite:
    image: node:20-alpine
    container_name: kiwimap_vite
    working_dir: /var/www
    volumes:
      - ./:/var/www
    ports:
      - "5173:5173"
    command: sh -c "npm install && npm run dev -- --host 0.0.0.0 --port 5173"

volumes:
  dbdata:
```

### URLs
- App: `http://localhost:8080`
- phpMyAdmin: `http://localhost:8081`
- Vite: `http://localhost:5173`

---

## 4) Dockerfile (PHP 8.2 + Composer + extensiones)
Archivo en la raíz: `Dockerfile`

> Importante: agregamos `bcmath` porque Composer falló sin esa extensión.

```dockerfile
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libicu-dev \
    && docker-php-ext-install pdo_mysql intl zip bcmath \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
```

---

## 5) Config de Nginx
Archivo: `docker/nginx/default.conf`

```nginx
server {
    listen 80;
    server_name localhost;

    root /var/www/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass app:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 6) Variables .env (mínimas para Docker)

### A) APP_URL (clave para Tailwind/Vite)
Como la app corre en 8080:

```env
APP_URL=http://localhost:8080
```

### B) DB (clave: dentro de Docker NO es 127.0.0.1)
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=kiwimap
DB_USERNAME=kiwimap
DB_PASSWORD=kiwimap
```

### C) Cache (recomendado local)
Evita errores si cache estaba en database:

```env
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

---

## 7) vite.config.js (fix para Docker)
Para que Tailwind/HMR funcione, usa esto en `vite.config.js`:

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    tailwindcss(),
  ],
  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    cors: true,
    hmr: { host: 'localhost' },
  },
});
```

---

## 8) Layout Blade (confirmación)
Tu layout debe incluir:

```php
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

---

# 9) COMANDOS — Primera vez (setup completo)
En PowerShell, en la raíz del proyecto:

### 1) Levantar contenedores (primera vez o tras cambios en Dockerfile)
```powershell
docker compose up -d --build
```

### 2) Instalar dependencias PHP (Composer)
```powershell
docker compose exec app composer install
```

### 3) Crear .env si no existe
```powershell
copy .env.example .env
```

### 4) Generar key
```powershell
docker compose exec app php artisan key:generate
```

### 5) Limpiar config/cache (si cambiaste .env)
```powershell
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
```

### 6) Migraciones
```powershell
docker compose exec app php artisan migrate
```

### 7) Storage link
```powershell
docker compose exec app php artisan storage:link
```

### 8) (Opcional) Seeders
```powershell
docker compose exec app php artisan db:seed
```

---

# 10) COMANDOS — Día a día (lo que haces siempre)

### Encender (sin rebuild)
```powershell
docker compose up -d
```

### Ver estado
```powershell
docker compose ps
```

### Ver logs (todo)
```powershell
docker compose logs -f
```

### Ver logs por servicio
```powershell
docker compose logs -f app
docker compose logs -f web
docker compose logs -f db
docker compose logs -f vite
```

### Apagar
```powershell
docker compose down
```

---

# 11) COMANDOS — Rebuild / Limpieza / Reset

### Rebuild (solo si cambias Dockerfile o versión de PHP/extensiones)
```powershell
docker compose up -d --build
```

### Reiniciar un servicio específico
```powershell
docker compose restart vite
docker compose restart web
docker compose restart app
docker compose restart db
```

### Borrar cache/config de Laravel (recomendado)
```powershell
docker compose exec app php artisan optimize:clear
```

### Limpiar composer autoload
```powershell
docker compose exec app composer dump-autoload
```

### Reset total de DB (BORRA la DB local)
⚠️ Esto borra el volumen `dbdata`:

```powershell
docker compose down -v
docker compose up -d --build
docker compose exec app php artisan migrate
```

---

# 12) Troubleshooting rápido (errores que ya resolvimos)

## A) Composer dice: `requires ext-bcmath -> it is missing`
✅ Solución: agregar `bcmath` en Dockerfile:
```dockerfile
docker-php-ext-install ... bcmath
```
Luego:
```powershell
docker compose up -d --build
```

## B) Error DB: `Host 127.0.0.1` / `Connection refused`
✅ En Docker, DB host es **db**, no localhost:
```env
DB_HOST=db
DB_PORT=3306
```
Luego:
```powershell
docker compose exec app php artisan config:clear
```

## C) Tailwind no aparece (pero la app corre)
✅ Checklist:
1) Vite está arriba:
```powershell
docker compose logs -f vite
```
2) `APP_URL=http://localhost:8080`
3) `vite.config.js` con `host/port/hmr` (ver sección 7)
4) Layout con `@vite([...])`

## D) Cache error: `Table 'kiwimap.cache' doesn't exist`
✅ Pasa si `CACHE_STORE=database` sin migración cache. Solución recomendada local:
```env
CACHE_STORE=file
SESSION_DRIVER=file
```
Luego:
```powershell
docker compose exec app php artisan config:clear
```

---

# 13) Verificaciones rápidas (para saber si todo está OK)

### PHP versión
```powershell
docker compose exec app php -v
```

### Extensión bcmath presente
```powershell
docker compose exec app php -m | findstr bcmath
```

### DB responde (desde Laravel)
```powershell
docker compose exec app php artisan tinker --execute="DB::select('select 1'); echo 'DB OK';"
```

### Vite accesible
Abre en navegador:
- `http://localhost:5173/@vite/client`

---

# 14) Nota de operación inteligente (para no perder tiempo)
- **NO corras `--build` siempre**. Úsalo solo cuando cambiaste Dockerfile o versión/extensiones.
- Para trabajar normal:
  ```powershell
  docker compose up -d
  ```

---

## 15) (Opcional) .dockerignore recomendado
Crea `.dockerignore` en la raíz:

```gitignore
node_modules
vendor
storage/logs
storage/framework/cache
storage/framework/sessions
storage/framework/views
.idea
.vscode
.git
.env
```

---

# Mini-resumen (para tu yo del futuro)
- **Arrancar**: `docker compose up -d`
- **Rebuild**: `docker compose up -d --build`
- **Composer**: `docker compose exec app composer install`
- **Artisan**: `docker compose exec app php artisan ...`
- **Vite logs**: `docker compose logs -f vite`
- **DB reset**: `docker compose down -v`


# Ver que Laravel corre (comando interno)
docker compose exec app php artisan about
✅ Si esto corre sin error, tu app está viva y leyendo config.


docker compose exec vite npm run build


docker exec -it kiwimap-app-1 php artisan migrate
docker exec -it kiwimap-app-1 php artisan config:clear
docker exec -it kiwimap-app-1 php artisan cache:clear
docker exec -it kiwimap-app-1 php artisan migrate

