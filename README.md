# PHP Template - Sistema de Rutas Simple

Un template básico de PHP con un sistema de rutas simple para crear sitios web estáticos o dinámicos.

## Estructura del Proyecto

```
php-template/
├── .htaccess            # Redirección principal (para Apache)
├── index.php            # Punto de entrada principal
├── router.php           # Router para servidor PHP integrado
├── README.md            # Este archivo
├── app/                 # Sistema y configuración
│   ├── Config.php       # Configuración general del sitio
│   ├── Controller.php   # Clase base para controladores
│   ├── Router.php       # Clase principal del sistema de rutas
│   └── Routes.php       # Definición de rutas de la aplicación
└── pages/               # Recursos visuales y contenido
    ├── css/            # Estilos CSS
    │   └── style.css   # Hoja de estilos principal
    ├── js/             # Scripts JavaScript
    │   └── main.js     # JavaScript principal
    ├── images/         # Imágenes del sitio
    ├── views/          # Vistas PHP
    │   ├── layouts/    # Layouts reutilizables
    │   │   └── main.php # Layout principal
    │   └── pages/      # Páginas del sitio
    │       ├── home.php
    │       ├── about.php
    │       ├── contact.php
    │       ├── services.php
    │       ├── blog.php
    │       ├── blog-post.php
    │       └── 404.php
    └── [archivos adicionales duplicados para compatibilidad]
```

## Instalación y Uso

### Para Desarrollo (Servidor PHP Integrado)

```bash
# Clonar el repositorio
git clone https://github.com/Nebulatools/php-template.git
cd php-template

# Levantar servidor de desarrollo
php -S localhost:8000 router.php
```

Luego abre http://localhost:8000 en tu navegador.

### Para Producción (Apache/Nginx)

1. Configura tu servidor web para apuntar al directorio del proyecto
2. Asegúrate de que mod_rewrite esté habilitado en Apache
3. Los archivos .htaccess manejarán las URLs amigables automáticamente

## Configuración

### Archivo app/Config.php

```php
define('SITE_NAME', 'Mi Sitio Web');
define('BASE_URL', 'http://localhost/php-template');
define('DEFAULT_LAYOUT', 'pages/layouts/main');
```

## Sistema de Rutas

Las rutas se definen en `app/Routes.php`:

```php
// Ruta simple
$router->add('/', ['view' => 'pages/home', 'title' => 'Inicio']);

// Ruta con parámetros
$router->add('/blog/{slug}', ['view' => 'pages/blog-post', 'title' => 'Blog Post']);
```

### Rutas Disponibles

- `/` - Página de inicio
- `/about` - Acerca de
- `/contact` - Contacto
- `/services` - Servicios
- `/blog` - Lista de blog
- `/blog/{slug}` - Post individual del blog

## Crear Nuevas Páginas

1. Crea un archivo PHP en `pages/views/pages/`
2. Agrega la ruta en `app/Routes.php`
3. La página usará automáticamente el layout principal

### Ejemplo de nueva página:

```php
// pages/views/pages/nueva-pagina.php
<div class="container">
    <h1>Nueva Página</h1>
    <p>Contenido de la página...</p>
</div>
```

```php
// app/Routes.php
$router->add('/nueva-pagina', ['view' => 'pages/nueva-pagina', 'title' => 'Nueva Página']);
```

## Arquitectura del Sistema de Rutas

El proyecto utiliza una arquitectura de doble router optimizada:

### router.php (raíz) - Router de Archivos Estáticos
- **Propósito**: Exclusivamente para servidor PHP integrado (`php -S`)
- **Función**: 
  - Sirve archivos estáticos (CSS, JS, imágenes, fuentes)
  - Establece content-types correctos automáticamente
  - Redirecciona peticiones dinámicas a `index.php`
- **Uso**: Solo desarrollo local con `php -S`
- **Código**: ~40 líneas, muy optimizado

### app/Router.php - Clase Sistema de Rutas
- **Propósito**: Motor principal del sistema MVC
- **Función**:
  - Pattern matching de URLs con expresiones regulares
  - Renderizado de vistas y layouts
  - Manejo de parámetros dinámicos
  - Controladores y acciones
- **Uso**: Desarrollo y producción
- **Código**: Clase completa con toda la lógica

### ¿Por qué esta separación?

1. **router.php** debe estar en la raíz porque el servidor PHP integrado lo requiere como entry point
2. **app/Router.php** es la clase del sistema que maneja toda la lógica MVC
3. Esta separación mantiene responsabilidades claras y código limpio

## Características

- ✅ URLs amigables con mod_rewrite
- ✅ Sistema de rutas flexible con soporte para parámetros
- ✅ Layout reutilizable con sistema de componentes
- ✅ Estructura MVC básica
- ✅ Sin dependencias externas
- ✅ Fácil de extender
- ✅ Servidor de desarrollo integrado
- ✅ CSS responsivo moderno
- ✅ JavaScript para navegación activa
- ✅ Manejo de errores 404

## Requisitos

- PHP 7.0 o superior
- Apache con mod_rewrite habilitado (para producción)
- Servidor con soporte PHP (para desarrollo se incluye servidor integrado)

## Personalización

### CSS
Edita `pages/css/style.css` para personalizar los estilos. El archivo incluye:
- Variables CSS para colores y espaciado
- Diseño responsivo con media queries
- Estilos para navegación, formularios y componentes

### JavaScript
Modifica `pages/js/main.js` para agregar funcionalidad. Incluye:
- Navegación activa automática
- Funciones utilitarias básicas

### Layout
Modifica `pages/views/layouts/main.php` para cambiar la estructura general del sitio.

## Estructura de Archivos Explicada

### `/app/` - Sistema y Configuración
Contiene toda la lógica del sistema: configuración, rutas, y el motor de routing.

### `/pages/` - Recursos Visuales
Contiene todo el contenido visual: HTML, CSS, JS, imágenes y vistas.

### Archivos en la Raíz
- `.htaccess`: Configuración para Apache
- `index.php`: Punto de entrada principal
- `router.php`: Router específico para desarrollo con `php -S`

## Notas

- Este es un template básico sin base de datos
- Para proyectos más complejos, considera usar un framework como Laravel o Symfony
- El sistema está optimizado para sitios web simples y páginas estáticas/semi-dinámicas
- Incluye protección básica contra acceso directo a archivos PHP
- Asegúrate de implementar medidas de seguridad adicionales para producción

## Comandos Útiles

```bash
# Servidor de desarrollo
php -S localhost:8000 router.php

# Verificar sintaxis PHP
php -l app/Router.php

# Ver estructura de archivos
tree -I 'node_modules|.git'
```