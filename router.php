<?php
/**
 * Router para servidor PHP integrado (php -S)
 * Solo maneja archivos estáticos y redirecciona al sistema principal
 */
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
// Verificar si es un archivo estático (CSS, JS, imágenes, etc.)
$static_file = __DIR__ . '/pages' . $path;
if (is_file($static_file)) {
    // Establecer content-type correcto para archivos estáticos
    $extension = pathinfo($static_file, PATHINFO_EXTENSION);
    $content_types = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2'
    ];
    if (isset($content_types[$extension])) {
        header('Content-Type: ' . $content_types[$extension]);
    }
    readfile($static_file);
    return true;
}
// Si no es archivo estático, pasar al sistema de rutas
$route = $path ?: '/';
$_GET['route'] = $route;
require_once __DIR__ . '/index.php';
?>