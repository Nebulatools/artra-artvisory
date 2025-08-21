<?php
define('ROOT', __DIR__);
define('APP', ROOT . '/app');
define('PAGES', ROOT . '/public');
define('VIEWS', PAGES . '/views');
require_once APP . '/Config.php';
require_once APP . '/Router.php';
require_once APP . '/Controller.php';
require_once APP . '/Routes.php';
$router = new Router();
configureRoutes($router);
$route = $_GET['route'] ?? '/';
$router->dispatch($route);
?>