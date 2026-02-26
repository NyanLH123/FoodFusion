<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

spl_autoload_register(function ($class) {
    if (file_exists('app/controllers/' . $class . '.php')) {
        require_once 'app/controllers/' . $class . '.php';
    } elseif (file_exists('app/models/' . $class . '.php')) {
        require_once 'app/models/' . $class . '.php';
    } elseif (file_exists('app/middlewares/' . $class . '.php')) {
        require_once 'app/middlewares/' . $class . '.php';
    }
});

require_once 'app/config/config.php';
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$url = filter_var($url, FILTER_SANITIZE_URL);
$urlParts = explode('/', $url);

$controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) : 'HomeController';
$methodName = isset($urlParts[1]) ? $urlParts[1] : 'index';

switch ($controllerName) {
    case 'auth':
        $controller = new AuthController();
        $methodName = isset($urlParts[1]) ? $urlParts[1] : 'login';
        break;
    default:
        http_response_code(404);
        echo "Page not found";
        exit;
}