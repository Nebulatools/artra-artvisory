<?php
define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('CONFIG', ROOT . '/config');
define('VIEWS', __DIR__ . '/pages');

require_once CONFIG . '/config.php';
require_once APP . '/core/Router.php';
require_once CONFIG . '/routes.php';

$router = new Router();

configureRoutes($router);

$route = $_GET['route'] ?? '/';
$router->dispatch($route);