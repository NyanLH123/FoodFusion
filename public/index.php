<?php
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__) . '/app/';

    $class = str_replace('app\\', '', $class);
    $relative = str_replace('\\', '/', $class) . '.php';
    $path = $root . $relative;

    if (file_exists($path)) {
        require_once $path;
        return;
    }

    $segments = explode('/', $relative);
    $file = array_pop($segments);
    $lowerPath = $root . implode('/', array_map('strtolower', $segments));
    if ($lowerPath !== $root) {
        $lowerPath .= '/';
    }
    $lowerPath .= strtolower($file);

    if (file_exists($lowerPath)) {
        require_once $lowerPath;
    }
});

error_reporting(E_ALL);
ini_set('display_errors', 1);

use app\core\Router;
use app\core\Session;

Session::init();
new Router();
