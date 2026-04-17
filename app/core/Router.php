<?php

declare(strict_types=1);

class Router
{
    private array $routes;
    private array $appConfig;

    public function __construct(array $routes, array $appConfig)
    {
        $this->routes    = $routes;
        $this->appConfig = $appConfig;
    }

    public function dispatch(): void
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $uri    = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

        // Strip base path prefix so routes match cleanly
        $base = parse_url((string) ($this->appConfig['base_url'] ?? ''), PHP_URL_PATH) ?: '';
        if ($base !== '' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }
        $uri = '/' . ltrim($uri, '/');
        // Normalize trailing slash (keep root as-is)
        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = rtrim($uri, '/');
        }

        $key = $method . ' ' . $uri;

        if (!isset($this->routes[$key])) {
            // Try with GET fallback for HEAD
            if ($method === 'HEAD') {
                $key = 'GET ' . $uri;
            }
        }

        if (!isset($this->routes[$key])) {
            $this->notFound();
            return;
        }

        [$controllerClass, $action] = explode('@', $this->routes[$key], 2);

        if (!class_exists($controllerClass)) {
            $this->notFound();
            return;
        }

        $controller = new $controllerClass($this->appConfig);

        if (!method_exists($controller, $action)) {
            $this->notFound();
            return;
        }

        $controller->$action();
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo '<!doctype html><html><body style="font-family:sans-serif;padding:2rem"><h1>404 — Page not found</h1><p><a href="/">Go home</a></p></body></html>';
    }
}
