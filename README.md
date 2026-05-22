# TSM - Sistema de Gestión de Contenidos Web

## Descripción
TSM es un CMS (Content Management System) desarrollado en PHP puro, JavaScript y CSS que permite gestionar páginas web de manera dinámica a través de un panel de administración intuitivo.

## Características Principales

- ✅ **Panel de Administración Moderno** - Interfaz limpia y responsive
- ✅ **Gestión de Páginas** - CRUD completo para páginas dinámicas
- ✅ **Editor WYSIWYG** - Integración con TinyMCE para edición de contenido
- ✅ **Sistema de Autenticación** - Login seguro con sesiones
- ✅ **Configuración del Sitio** - Administración de settings generales
- ✅ **SEO Friendly** - Meta descripciones, keywords y slugs personalizables
- ✅ **Registro de Actividad** - Log de todas las acciones del sistema
- ✅ **Multi-plantilla** - Soporte para diferentes templates de página

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior / MariaDB
- Servidor web (Apache, Nginx)
- Extensión PDO habilitada

## Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/csandovall-dev/TSM.git
cd TSM
```

### 2. Configurar la base de datos
- Crear una base de datos llamada `tsm_db`
- Importar el archivo `config/database.sql`
- Editar `config/database.php` con tus credenciales:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'tsm_db');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
```

### 3. Configurar la URL base
Editar `config/config.php` y establecer la URL correcta:

```php
define('BASE_URL', 'http://tudominio.com/');
```

### 4. Permisos de carpetas
Asegurar que la carpeta `uploads/` tenga permisos de escritura:

```bash
chmod 755 uploads/
```

## Acceso al Panel de Administración

- **URL:** `http://tudominio.com/admin/login`
- **Usuario:** `admin`
- **Contraseña:** `tsm_2026`

⚠️ **Importante:** Cambia la contraseña después del primer acceso.

## Estructura del Proyecto

```
TSM/
├── assets/              # Recursos estáticos
│   ├── css/            # Hojas de estilo
│   ├── js/             # Scripts JavaScript
│   └── images/         # Imágenes
├── config/             # Configuración
│   ├── config.php      # Configuración general
│   ├── database.php    # Conexión a BD
│   └── database.sql    # Script de instalación
├── controllers/        # Controladores
│   ├── AuthController.php
│   ├── DashboardController.php
│   └── PageController.php
├── models/            # Modelos de datos
│   ├── Model.php      # Modelo base
│   ├── UserModel.php
│   ├── PageModel.php
│   └── SettingModel.php
├── views/             # Vistas
│   ├── admin/         # Panel de administración
│   │   ├── includes/  # Componentes reutilizables
│   │   └── pages/     # Vistas de páginas
│   └── public/        # Frontend público
├── uploads/           # Archivos subidos
└── index.php          # Enrutador principal
```

## Base de Datos

El sistema incluye las siguientes tablas:

| Tabla | Descripción |
|-------|-------------|
| `users` | Usuarios del sistema |
| `pages` | Páginas dinámicas |
| `sections` | Secciones dentro de páginas |
| `galleries` | Galerías de imágenes |
| `gallery_images` | Imágenes de galerías |
| `services` | Servicios |
| `portfolio` | Proyectos/Portafolio |
| `testimonials` | Testimonios de clientes |
| `team_members` | Miembros del equipo |
| `contacts` | Mensajes de contacto |
| `settings` | Configuración del sitio |
| `activity_log` | Registro de actividad |

## Funcionalidades del Panel Admin

### Dashboard
- Estadísticas generales
- Actividad reciente del sistema

### Gestión de Páginas
- Crear, editar, eliminar páginas
- Editor visual TinyMCE
- Configuración de SEO
- Gestión de estados (publicado/borrador)
- Plantillas personalizables

### Configuración del Sitio
- Información general
- Logo y favicon
- Datos de contacto
- Redes sociales
- Google Analytics
- Modo mantenimiento

## Seguridad

- Contraseñas hasheadas con bcrypt
- Protección contra SQL Injection (PDO preparado)
- Protección XSS (htmlspecialchars)
- Sesiones seguras
- Validación de archivos subidos

## Próximas Funcionalidades (Roadmap)

- [ ] Gestión completa de servicios
- [ ] Gestión de portafolio
- [ ] Gestión de testimonios
- [ ] Gestión de equipo
- [ ] Gestión de galerías
- [ ] Módulo de contactos
- [ ] Editor de secciones por página
- [ ] Multi-language
- [ ] API REST
- [ ] Tema frontend completo

## Tecnologías Utilizadas

- **Backend:** PHP 7.4+
- **Base de Datos:** MySQL/MariaDB
- **Frontend Admin:** HTML5, CSS3, JavaScript
- **Editor:** TinyMCE 6
- **Patrón:** MVC (Model-View-Controller)

## Licencia

Este proyecto está bajo licencia MIT.

## Autor

Desarrollado por csandovall-dev

## Soporte

Para reportar errores o sugerencias, por favor crea un issue en el repositorio.

---

**¡Gracias por usar TSM!** 🚀
