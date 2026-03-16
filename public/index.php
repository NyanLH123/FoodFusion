<?php
spl_autoload_register(function ($class) {

    $path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($path)) {
        require_once $path;
    }

});
use app\core\Router;
use app\core\Session;
use app\controllers\Home;

Session::init();
$router = new Router();
$router->add('GET', '/', [Home::class, 'index']); 
$router->dispatch();