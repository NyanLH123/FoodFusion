<?php
spl_autoload_register(function ($class) {

    $root = dirname(__DIR__) . '/app/';

    $class = str_replace('app\\', '', $class);
    $path = $root . str_replace('\\', '/', $class) . '.php';

    if (file_exists($path)) {
        require_once $path;
    }
});
error_reporting(E_ALL);
ini_set('display_errors', 1);

use app\core\Router;
use app\core\Session;

Session::init();
// Initialize Router
new Router();
?>