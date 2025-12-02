<?php
function configureRoutes($router) {
    $router->add('/', ['controller' => 'Controller', 'action' => 'index']);
    $router->add('/home', ['controller' => 'Controller', 'action' => 'home']);
    $router->add('/about', ['controller' => 'Controller', 'action' => 'about']);
    $router->add('/artists', ['controller' => 'Controller', 'action' => 'artists']);
    $router->add('/catalogue', ['controller' => 'Controller', 'action' => 'catalogue']);
    $router->add('/contact', ['controller' => 'Controller', 'action' => 'contact']);
    $router->add('/gallery', ['controller' => 'Controller', 'action' => 'gallery']);
    $router->add('/how-we-do-it', ['controller' => 'Controller', 'action' => 'hwdi']);
    $router->add('/location', ['controller' => 'Controller', 'action' => 'location']);

    $router->add('/artworks', ['controller' => 'Controller', 'action' => 'artworks']);
    $router->add('/work/01', ['controller' => 'Works', 'action' => 'work_01']);
    $router->add('/work/02', ['controller' => 'Works', 'action' => 'work_02']);
    $router->add('/work/03', ['controller' => 'Works', 'action' => 'work_03']);
    $router->add('/work/04', ['controller' => 'Works', 'action' => 'work_04']);
    $router->add('/work/05', ['controller' => 'Works', 'action' => 'work_05']);

    $router->add('/frames', ['controller' => 'Controller', 'action' => 'frames']);
    $router->add('/frame/745037', ['controller' => 'Frames', 'action' => 'frame_745037']);
    $router->add('/frame/535046', ['controller' => 'Frames', 'action' => 'frame_535046']);
    $router->add('/frame/869048', ['controller' => 'Frames', 'action' => 'frame_869048']);
    $router->add('/frame/606052', ['controller' => 'Frames', 'action' => 'frame_606052']);
    
    $router->add('/blog', ['controller' => 'Controller', 'action' => 'blog']);
    $router->add('/blog/{slug}', ['controller' => 'Controller', 'action' => 'blog']);
}
?>