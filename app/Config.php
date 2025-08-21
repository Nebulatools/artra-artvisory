<?php
define('SITE_NAME', 'ARTRA');
define('BASE_URL', 'http://localhost/artra-landing/');
define('DEFAULT_LAYOUT', 'pages/layouts/main');
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Mexico_City');
session_start();
/* Función para renderizar vistas del sistema de layers del Controller */
function view($view, $data = []) {
    extract($data);
    $viewFile = VIEWS . '/' . $view . '.php';
    if (file_exists($viewFile)) {
        ob_start();
        include $viewFile;
        return ob_get_clean();
    } else {
        throw new Exception("View file not found: " . $viewFile);
    }
}
?>