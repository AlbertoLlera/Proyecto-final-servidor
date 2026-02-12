# Instrucciones de Instalación - Proyecto Final Red Social

## Requisitos previos
- XAMPP instalado (con Apache y MySQL)
- Composer instalado
- Node.js y npm instalados
- PHP 8.1 o superior

## Pasos de instalación

### 1. Extraer el proyecto
Descomprimir el archivo ZIP en la carpeta `htdocs` de XAMPP.
```
C:\xampp\htdocs\nombre-del-proyecto\
```

### 2. Instalar dependencias de PHP
Abrir una terminal en la carpeta del proyecto y ejecutar:
```bash
composer install
```

### 3. Instalar dependencias de Node.js
En la misma terminal, ejecutar:
```bash
npm install
```

### 4. Configurar el archivo de entorno
Copiar el archivo `.env.example` y renombrarlo a `.env`:
```bash
copy .env.example .env
```

### 5. Generar la clave de la aplicación
Ejecutar el siguiente comando:
```bash
php artisan key:generate
```

### 6. Configurar la base de datos
1. Abrir XAMPP y iniciar Apache y MySQL
2. Acceder a phpMyAdmin (http://localhost/phpmyadmin)
3. Crear una nueva base de datos (por ejemplo: `red_social`)
4. Editar el archivo `.env` y configurar la conexión a la base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=red_social
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Ejecutar las migraciones
Crear las tablas en la base de datos:
```bash
php artisan migrate
```

### 8. (Opcional) Ejecutar los seeders
Si se desea cargar datos de prueba:
```bash
php artisan db:seed
```

### 9. Crear enlace simbólico para el almacenamiento
Para que las imágenes funcionen correctamente:
```bash
php artisan storage:link
```

### 10. Compilar los assets
Compilar los archivos CSS y JavaScript:
```bash
npm run build
```
O para desarrollo:
```bash
npm run dev
```

### 11. Iniciar el servidor
Ejecutar el servidor de desarrollo de Laravel:
```bash
php artisan serve
```

La aplicación estará disponible en: **http://127.0.0.1:8000**

---

## Resumen de comandos principales

En orden de ejecución:
```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run build
php artisan serve
```

---

## Solución de problemas

### Error: "Please provide a valid cache path"
Verificar que existan las carpetas:
- `storage/framework/cache`
- `storage/framework/sessions`
- `storage/framework/views`

### Error de permisos en Windows
Asegurarse de que la carpeta `storage` y `bootstrap/cache` tengan permisos de escritura.

### Error de base de datos
Verificar que MySQL esté ejecutándose en XAMPP y que la configuración en `.env` sea correcta.

---

## Contacto
Para cualquier duda sobre la instalación, contactar con el desarrollador del proyecto.
