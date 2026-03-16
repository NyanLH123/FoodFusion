<?php
namespace app\core;
class Router
{
    protected $routes = [];

    public function add($method, $path, $handler)
    {
        $method = strtoupper($method);

        // Normalize path
        $path = $this->normalizePath($path);

        // Convert handler to callable
        $handler = is_callable($handler) ? $handler : [new $handler[0], $handler[1]];

        $this->routes[$method][$path] = $handler;
    }

    protected function normalizePath($path)
    {
        return '/' . trim($path, '/');
    }

    protected function getUrl()
    {
        $url = parse_url($_SERVER['REQUEST_URL'], PHP_URL_PATH);
        return $this->normalizePath($url);
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $this->getUrl();

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];

            return call_user_func($handler);
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}