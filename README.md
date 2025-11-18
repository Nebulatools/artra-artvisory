# ARTRA Artvisory – Website

Sitio web para **ARTRA Artvisory**, un gallery & framing studio.  
Es una aplicación PHP ligera, sin framework, que sirve páginas estáticas/semi-dinámicas mediante un router propio.

---

## 1. Estructura del proyecto

Raíz del proyecto:

```text
artra-artvisory/
├── .gitignore            # Configuración de Git
├── .htaccess             # Reescritura de URLs hacia index.php
├── index.php             # Front controller principal
├── router.php            # Router opcional para servidor PHP integrado
├── app/                  # Lógica de aplicación y sistema de rutas
└── public/               # Assets públicos y vistas
```

Detalle de carpetas clave:

```text
app/
├── Config.php            # Configuración global (SITE_NAME, BASE_URL, timezone, sesión)
├── Controller.php        # Controlador principal de páginas
├── Frames.php            # Controlador para detalles de marcos
├── Works.php             # Controlador para detalles de obras
├── Router.php            # Router interno (matching de rutas y renderizado)
└── Routes.php            # Definición de rutas de la aplicación

public/
├── assets/
│   ├── css/              # CSS modular (home, about, artworks, frames, gallery, hwdi, layout, etc.)
│   ├── js/               # JS vanilla (menú, acordeones de catálogo)
│   ├── image/            # Imágenes de secciones, obras y marcos
│   ├── font/             # Tipografías locales
│   ├── icon/             # Favicons
│   └── svg/              # Logotipos y elementos vectoriales
└── views/
    ├── layouts/
    │   ├── head.php      # <head>, metadatos, CSS y JS global
    │   ├── header.php    # Navegación y menú principal
    │   └── footer.php    # Footer global
    ├── home.php          # Home / landing
    ├── about.php         # “About our framing studio”
    ├── artworks.php      # Listado de obras destacadas
    ├── artists.php       # Sección de artistas (no enlazada en menú)
    ├── frames.php        # Catálogo de marcos (overview)
    ├── gallery.php       # Upcoming gallery
    ├── hwdi.php          # “How we do it”
    ├── catalogue.php     # Catálogo extendido (acordeones)
    ├── frame_detail.php  # Plantilla genérica de detalle (legacy)
    ├── 404.php           # Página de error 404
    ├── artworks/*.php    # Detalle de obras (work_01…work_04)
    └── frames/*.php      # Detalle de marcos (roma_745037, etc.)
```

---

## 2. Stack técnico y requisitos

- **Lenguaje:** PHP 7.4+ (recomendado PHP 8.x).
- **Servidor web:** Apache 2.4+ o Nginx (con soporte para URLs amigables).
- **Reescritura:** `mod_rewrite` habilitado (en Apache) y `AllowOverride All` en el vhost para que `.htaccess` funcione.
- **Base de datos:** No utiliza base de datos; todo el contenido está en vistas PHP/HTML.
- **Frontend:** HTML5, CSS modular en `public/assets/css/`, JavaScript vanilla en `public/assets/js/` (sin frameworks).
- **Sesiones y zona horaria:** gestionadas en `app/Config.php` (incluye `session_start()` y `date_default_timezone_set('America/Mexico_City')`).

Dependencias externas:

- Fuentes de **Google Fonts (Inter)** cargadas vía `<link>`.
- Tipografías locales (`CenturyOldStyleStd-*.ttf`, `Sohne-Kraftig.otf`) precargadas desde `public/assets/font/`.

No se usan Composer, frameworks PHP ni paquetes adicionales.

---

## 3. Configuración de la aplicación

Archivo: `app/Config.php`

```php
define('SITE_NAME', 'ARTRA');
define('BASE_URL', 'http://localhost/artra-artvisory/');
define('DEFAULT_LAYOUT', 'pages/layouts/main'); // Actualmente no se utiliza

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Mexico_City');
session_start();
```

Puntos a ajustar según entorno:

- `SITE_NAME`: Nombre visible en el footer.
- `BASE_URL`:
  - **DEV local (XAMPP):** `http://localhost/artra-artvisory/`
  - **DEV/PROD en servidor virtual:** `https://tudominio.com/` o el subdominio correspondiente.
- `display_errors`:
  - **DEV:** `1` (mostrar errores en pantalla).
  - **PROD:** recomienda cambiar a `0` y configurar logging en el servidor.
- `date_default_timezone_set`: ajusta la zona horaria a la región del servidor/proyecto.

---

## 4. Arquitectura del sistema

### 4.1. Front controller

- `index.php` es el punto de entrada único.
- Define constantes de rutas:
  - `ROOT`, `APP`
  - `PAGES` → `public`
  - `VIEWS` → `public/views`
- Incluye `Config.php`, los controladores (`Controller.php`, `Frames.php`, `Works.php`), `Router.php` y `Routes.php`.
- Obtiene la ruta amigable desde `$_GET['route']` (inyectada por `.htaccess`) y la pasa al router:
  - Si no viene nada, usa `/`.

### 4.2. Router interno (`app/Router.php`)

- Registra rutas con `Router::add($pattern, $params)`:
  - Soporta parámetros como `{slug}` o `{id:[0-9]+}` mediante expresiones regulares.
- `dispatch($url)`:
  - Normaliza la URL (elimina query strings).
  - Busca coincidencia en las rutas registradas.
  - Si hay **controller + action**:
    - Convierte el nombre de controller a `StudlyCaps` (por ejemplo, `frames` → `Frames`).
    - Instancia el controlador y ejecuta el método (`home`, `about`, etc.).
  - Si solo hay **view**:
    - Renderiza directamente una vista (`renderView()`).
  - Si no hay coincidencia:
    - Renderiza `public/views/404.php`.

### 4.3. Controladores y vistas

- `Controller.php`:
  - Método `render($page, $title)`:
    - Renderiza `layouts/head`, `layouts/header`, la vista principal y `layouts/footer`.
  - Acciones principales:
    - `index`, `home`, `about`, `artworks`, `artists`,
      `catalogue`, `frames`, `gallery`, `hwdi`.
- `Frames.php` y `Works.php`:
  - Renderizan vistas específicas bajo `views/frames/` y `views/artworks/`.
  - Cada acción corresponde a un detalle de marco/obra
    (ej: `frame_745037`, `work_01`).
- Vistas:
  - Las vistas principales (`home.php`, `about.php`, `artworks.php`, etc.)
    construyen cada sección del sitio.
  - Los detalles de obras/marcos se encuentran en subcarpetas dedicadas.

### 4.4. Reescritura de URLs (`.htaccess`)

```apacheconf
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?route=/$1 [QSA,L]
AddDefaultCharset UTF-8
```

- Todas las rutas amigables (`/about`, `/frames`, etc.) se redirigen a
  `index.php` con `route=/about`, `route=/frames`, etc.
- Archivos físicos (`.css`, `.js`, imágenes) se sirven directamente
  sin pasar por PHP.

---

## 5. Rutas existentes

Las rutas se definen en `app/Routes.php`. A día de hoy están configuradas:

### 5.1. Páginas principales

- `/` → `Controller@index` → `home.php` (landing principal).
- `/home` → `Controller@home` (alias de la home).
- `/about` → `Controller@about` (About our framing studio).
- `/artworks` → `Controller@artworks` (listado de obras / curated moments).
- `/frames` → `Controller@frames` (overview del catálogo de marcos).
- `/gallery` → `Controller@gallery` (upcoming gallery).
- `/how-we-do-it` → `Controller@hwdi` (proceso y metodología).

### 5.2. Secciones adicionales

- `/artists` → `Controller@artists`  
  Vista: `public/views/artists.php`.  
  La ruta existe aunque actualmente no está enlazada desde el menú.

- `/catalogue` → `Controller@catalogue`  
  Vista: `public/views/catalogue.php` (catálogo extendido con acordeones
  controlados por `catalogue.js`).

### 5.3. Detalles de obras (Works)

- `/artworks` → vista general (enlaces a cada obra).
- `/work/01` → `Works@work_01` → `public/views/artworks/work_01.php`
- `/work/02` → `Works@work_02` → `public/views/artworks/work_02.php`
- `/work/03` → `Works@work_03` → `public/views/artworks/work_03.php`
- `/work/04` → `Works@work_04` → `public/views/artworks/work_04.php`

### 5.4. Detalles de marcos (Frames)

- `/frames` → overview (enlaces a cada marco).
- `/frame/745037` → `Frames@frame_745037`
  → `public/views/frames/roma_745037.php`
- `/frame/535046` → `Frames@frame_535046`
  → `public/views/frames/roma_535046.php`
- `/frame/869048` → `Frames@frame_869048`
  → `public/views/frames/roma_869048.php`
- `/frame/606052` → `Frames@frame_606052`
  → `public/views/frames/roma_606052.php`

### 5.5. Rutas reservadas / en construcción

En `Routes.php` existen rutas declaradas para:

- `/blog`
- `/blog/{slug}`

Actualmente no hay controlador ni vistas asociadas para estas rutas,
por lo que están reservadas para futuras extensiones.

---

## 6. Instalación y uso

### 6.1. Desarrollo local (Apache/XAMPP, MAMP, WAMP)

1. Clona o copia el proyecto dentro del `DocumentRoot` de tu servidor local, por ejemplo:
   - Windows (XAMPP): `C:\xampp\htdocs\artra-artvisory`
   - Linux: `/var/www/html/artra-artvisory`
2. Asegúrate de que Apache tenga habilitado `mod_rewrite` y `AllowOverride All`
   para esa carpeta.
3. Edita `app/Config.php` y ajusta:
   - `BASE_URL` a `http://localhost/artra-artvisory/`
     (o la ruta que uses).
4. Inicia Apache.
5. Abre en el navegador: `http://localhost/artra-artvisory/`.

> Nota: En desarrollo la configuración actual muestra errores PHP en pantalla
> (`display_errors = 1`) para facilitar el debug.

### 6.2. Desarrollo con servidor PHP integrado (opcional)

También puedes usar el servidor embebido de PHP, siempre que tu entorno lo permita:

```bash
cd /ruta/al/proyecto/artra-artvisory
php -S localhost:8000 router.php
```

Luego navega a `http://localhost:8000/`.

En este modo:

- `router.php` se encarga de servir archivos estáticos
  (`/public/assets/...`) y redirigir el resto a `index.php`
  para que el router interno procese las rutas amigables.

### 6.3. Despliegue en servidor virtual – DEV vs PROD

Se asume un servidor virtual (VPS) Linux con Apache (LAMP) o stack similar.

#### 6.3.1. Pasos comunes (DEV y PROD)

1. Crear directorio del sitio, por ejemplo:
   - `/var/www/artra-artvisory`
2. Subir el código (git, rsync, SCP, pipeline CI/CD, etc.).  
3. Dar permisos adecuados al usuario con el que corre Apache
   (por ejemplo, `www-data` o `apache`), sin dar más permisos de los necesarios.
4. Verificar que `mod_rewrite` esté habilitado.
5. Configurar el VirtualHost de Apache apuntando al directorio del proyecto.

Ejemplo básico de VirtualHost:

```apacheconf
<VirtualHost *:80>
    ServerName artra-artvisory.local
    DocumentRoot /var/www/artra-artvisory

    <Directory /var/www/artra-artvisory>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/artra-error.log
    CustomLog ${APACHE_LOG_DIR}/artra-access.log combined
</VirtualHost>
```

Habilita el sitio y recarga Apache:

```bash
a2ensite artra-artvisory.conf
systemctl reload apache2
```

#### 6.3.2. Entorno DEV en servidor virtual

Uso típico para un entorno de pruebas (`dev` o `staging`):

- Dominio/subdominio ejemplo: `dev.artra-artvisory.com`.
- Ajustes recomendados en `app/Config.php`:
  - `BASE_URL`: `https://dev.artra-artvisory.com/`
  - `display_errors`: puede permanecer en `1` mientras sea un entorno interno,
    pero es buena práctica ir desactivando errores en pantalla y usar logs.
- Mantener metadatos/robots apropiados
  (actualmente `head.php` tiene `googlebot: noindex, nofollow`).

#### 6.3.3. Entorno PROD en servidor virtual

Para producción (`www.artra-artvisory.com` o el dominio definitivo):

1. Configura un VirtualHost similar al de DEV pero con el dominio real
   y HTTPS (LetsEncrypt o certificado propio).
2. Ajusta en `app/Config.php`:
   - `BASE_URL`: `https://artra-artvisory.com/`
   - `ini_set('display_errors', 0);` y mantén `error_reporting(E_ALL)`
     pero dirigido a logs del servidor.
3. Verifica que `.htaccess` está activo (`AllowOverride All`)
   para que las rutas amigables funcionen.
4. Opcional: configurar cache de assets estáticos (`public/assets/...`)
   vía cabeceras en Apache o CDN.

En PROD se recomienda:

- No mostrar errores PHP en el navegador.
- Proteger el servidor con reglas de firewall, actualizaciones de sistema
  y backups periódicos del código.

---

## 7. Flujo de trabajo y extensión del sitio

### 7.1. Añadir una nueva página de contenido

1. Crear la vista en `public/views`, por ejemplo:

   ```php
   <!-- public/views/studio.php -->
   <main class="studio-main">
       <section>
           <h1>Our Studio</h1>
           <p>Contenido descriptivo...</p>
       </section>
   </main>
   ```

2. Añadir la acción en el controlador:

   ```php
   // app/Controller.php
   class Controller {
       // ...
       public function studio() {
           $this->render('studio', 'Studio');
       }
   }
   ```

3. Definir la ruta en `app/Routes.php`:

   ```php
   $router->add('/studio', ['controller' => 'Controller', 'action' => 'studio']);
   ```

4. Enlazarla desde el menú (`public/views/layouts/header.php`)
   o desde cualquier otra sección.

### 7.2. Añadir un nuevo detalle de obra o marco

- **Obras**:
  1. Crear vista en `public/views/artworks/work_05.php`.
  2. Añadir método `work_05()` en `app/Works.php`
     que llame a `work_render('work_05', 'Work #05')`.
  3. Registrar ruta en `app/Routes.php`:
     ```php
     $router->add('/work/05', ['controller' => 'Works', 'action' => 'work_05']);
     ```

- **Marcos**:
  1. Crear vista en `public/views/frames/roma_XXXXXX.php`.
  2. Añadir método correspondiente en `app/Frames.php`.
  3. Registrar ruta `/frame/XXXXXX` en `Routes.php`.

---

## 8. Notas finales

- El proyecto está pensado como un sitio de presentación para ARTRA,
  sin backend de administración ni base de datos.
- Toda la estructura está optimizada para ser simple de desplegar
  en cualquier servidor con PHP y Apache/Nginx.
- Cualquier cambio en URLs debe sincronizarse entre:
  - `app/Routes.php`
  - los controladores (`Controller.php`, `Frames.php`, `Works.php`)
  - y los enlaces en las vistas (`header.php`, `footer.php`, secciones internas).

Para cualquier entorno nuevo (staging, demo, subdominios) basta con:

- Ajustar `BASE_URL` en `Config.php`,
- desplegar el código en el nuevo vhost,
- y asegurarse de que `.htaccess` está activo.

