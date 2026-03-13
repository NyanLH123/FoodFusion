<?php

namespace app\core;

class Router
{
    private $controller = 'Home';
    private $method = 'index';
    private $params = [];

    private $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = $this->getPath();

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            $this->controller = $handler['controller'];
            $this->method = $handler['method'];
            return $this->callController();
        }

        http_response_code(404);
        die("Route not found: $method $path");

    }

    public function add($method, $path, $handler)
    {
        $handler = is_callable($handler) ? $handler : explode('/', $handler);
        $method = strtoupper($method);
        if (!in_array($method, ['GET', 'POST'])) {
            throw new \InvalidArgumentException("Unsupported HTTP method: $method");
        }
        $this->routes[$method][$path] = [
            'controller' => $handler[0],
            'method' => $handler[1],
            'params' => $handler[2] ?? []
        ];
    }

    public function getPath()
    {
        $url = $_SERVER['REQUEST_URI'] ?? '/';
        $path = rtrim(parse_url($url, PHP_URL_PATH), '/');
        return $path === '' ? '/' : $path;
    }

    public function callController() {
        $file = __DIR__ . '/../controllers/' . ucfirst($this->controller) . '.php';
        if (!file_exists($file)) {
            http_response_code(404);
            die("Controller file not found: {$this->controller}");
        }

        require_once $file;
        $class = "app\\controllers\\" . ucfirst($this->controller);
        if (!class_exists($class)) {
            http_response_code(500);
            die("Controller class not found: {$class}");
        }

        $obj = new $class();
        if (!method_exists($obj, $this->method)) {
            http_response_code(404);
            die("Method {$this->method} not found in {$this->controller}");
        }

        call_user_func_array([$obj, $this->method], $this->params);
    }
}
