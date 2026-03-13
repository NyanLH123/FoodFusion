<?php 

require_once __DIR__ . '/../vendor/autoload.php';

$router = new app\core\Router();

// Define your routes here
$router->add('GET', '/', ['Home', 'index']);
$router->add('GET', '/about', ['Home', 'about']);

$router->dispatch();


?>