<?php
function configureRoutes($router) {
    $router->add('/', ['controller' => 'Controller', 'action' => 'index']);
    $router->add('/home', ['controller' => 'Controller', 'action' => 'home']);
    $router->add('/about', ['controller' => 'Controller', 'action' => 'about']);
    $router->add('/artworks', ['controller' => 'Controller', 'action' => 'artworks']);
    $router->add('/artists', ['controller' => 'Controller', 'action' => 'artists']);
    $router->add('/how-we-do-it', ['controller' => 'Controller', 'action' => 'hwdi']);
    $router->add('/catalogue', ['controller' => 'Controller', 'action' => 'catalogue']);
    $router->add('/frame_detail', ['controller' => 'Controller', 'action' => 'frame_detail']);
    $router->add('/gallery', ['controller' => 'Controller', 'action' => 'gallery']);

    $router->add('/frames', ['controller' => 'Controller', 'action' => 'frames']);
    $router->add('/frame/(:num)', ['controller' => 'Frames', 'action' => 'frame/$1']);

    $router->add('/frame/745037', ['controller' => 'Controller', 'action' => 'frame_745037']);
    $router->add('/frame/745037', ['controller' => 'Frames', 'action' => 'frame_745037']);
    
    $router->add('/blog', ['controller' => 'Controller', 'action' => 'blog']);
    $router->add('/blog/{slug}', ['controller' => 'Controller', 'action' => 'blog']);
}
?>