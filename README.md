# Proyecto Final - Red Social

Una red social moderna desarrollada con **Laravel 12**, **Vite**, **Tailwind CSS** y **MySQL**. Permite a los usuarios crear posts, comentarios, likes, seguir otros usuarios y contar con un panel de administración completo.

## Tabla de Contenidos

- [Características](#características)
- [Requisitos](#requisitos)
- [Instalación (flujo mínimo)](#instalación-flujo-mínimo)
- [Uso](#uso)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Troubleshooting](#troubleshooting)

## Características

- Autenticación de usuarios (registro, login, logout)
- Crear, editar y eliminar posts
- Sistema de comentarios
- Sistema de likes
- Seguir y dejar de seguir usuarios
- Perfiles de usuario con imágenes
- Búsqueda de usuarios
- Panel de administración (gestión de usuarios, posts, comentarios)
- Roles de usuario (admin, usuario normal)
- Carga de imágenes optimizadas con Intervention Image
- Interfaz moderna con Tailwind CSS

## Requisitos

- **PHP**: 8.2 o superior
- **MySQL**: 5.7 o superior (o MariaDB)
- **Node.js**: 18.x o superior
- **Composer**: 2.x o superior
- **XAMPP** o servidor web local equivalente

## Instalación (flujo mínimo)

Este flujo asume que el ZIP ya incluye todo listo: `vendor/`, `node_modules/`, `public/build/` y `.env` configurado.

### 1. Descomprimir el proyecto

Extrae el archivo ZIP en la carpeta `htdocs` de XAMPP:

```bash
C:\xampp\htdocs\Proyecto-final-servidor\
```

### 2. Importar la base de datos

1. Abre **phpMyAdmin** (http://localhost/phpmyadmin)
2. Crea la base de datos (ej: `proyecto_final`)
3. Importa el archivo `.sql` entregado

### 3. Levantar la app

En una terminal:

```bash
php artisan serve
```

En otra terminal:

```bash
npm run dev
```

## Uso

### Modo desarrollo

Accede a: http://localhost:8000

### Alternativa usando Apache (XAMPP)

Si prefieres no usar `php artisan serve`, deja Apache corriendo en XAMPP y entra a:

```
http://localhost/Proyecto-final-servidor/proyectoFinal-redSocial-Alberto/public/
```

## Estructura del Proyecto

```
proyectoFinal-redSocial-Alberto/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Controladores de la aplicación
│   │   └── Middleware/       # Middleware personalizado
│   ├── Models/               # Modelos Eloquent (User, Post, etc.)
│   └── Policies/             # Políticas de autorización
├── bootstrap/                # Configuración de arranque
├── config/                   # Archivos de configuración
├── database/
│   ├── migrations/           # Migraciones de BD
│   ├── seeders/              # Seeds para datos de prueba
│   └── factories/            # Factories para tests
├── resources/
│   ├── css/                  # Estilos CSS
│   ├── js/                   # Scripts JavaScript
│   └── views/                # Vistas Blade
├── routes/
│   └── web.php               # Rutas de la aplicación
├── storage/                  # Almacenamiento de archivos
├── public/                   # Carpeta pública (punto de entrada)
├── tests/                    # Tests unitarios y funcionales
├── .env.example              # Ejemplo de configuración
├── composer.json             # Dependencias de PHP
├── package.json              # Dependencias de Node.js
└── vite.config.js            # Configuración de Vite
```

## Modelos de Datos

### User
- id, name, email, username, contraseña, imagen, rol

### Post
- id, user_id, contenido, imagen, timestamps

### Comentario
- id, post_id, user_id, contenido, timestamps

### Like
- id, post_id, user_id, timestamps

### Follower
- id, user_id, follower_id, timestamps

## Autenticación y Roles

- **Usuario Normal**: Puede crear posts, comentarios, likes y seguir usuarios
- **Administrador**: Acceso completo al panel de administración (/admin)

## Gestión de Imágenes

Las imágenes se guardan en:
- `storage/app/` (almacenamiento privado)
- `public/perfiles/` (imágenes de perfil accesibles públicamente)
- `public/img/` (imágenes de posts)

Las imágenes se optimizan automáticamente con **Intervention Image**.

## Testing

Ejecutar tests:

```bash
php artisan test
```

## Troubleshooting

### Error: "SQLSTATE[HY000]: General error"
- Verifica que MySQL esté corriendo
- Comprueba las credenciales en `.env`
- Ejecuta `php artisan migrate` nuevamente

### Error: "Class not found" o autoload
```bash
composer dump-autoload
```

### Assets no se cargan correctamente
```bash
npm run build
```

### Permisos de carpeta
Asegúrate de que Apache tiene permisos sobre las carpetas `storage` y `bootstrap/cache`:

```bash
php artisan storage:link
```

### La base de datos no se conecta
1. Verifica que `DB_CONNECTION=mysql` en `.env`
2. Confirma que MySQL está escuchando en puerto 3306
3. Prueba la conexión manualmente en phpMyAdmin

## Nota si faltan archivos

Si el ZIP no incluye `vendor/`, `node_modules/`, `public/build/` o el `.env`, entonces hay que ejecutar estos pasos adicionales:

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
npm run build
```

Nota rapida: si todo eso ya viene incluido en el ZIP, no hace falta ejecutar esos comandos.

## Documentación Adicional

- [Laravel Oficial](https://laravel.com/docs)
- [Vite](https://vitejs.dev/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Intervention Image](https://image.intervention.io/)

## Autor

**Alberto** - Proyecto Final

## Licencia

MIT

---

**Última actualización**: Febrero 2026

Para ayuda o problemas, contacta al desarrollador.
