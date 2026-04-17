<?php

declare(strict_types=1);

class App
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function run(): void
    {
        $routes = require ROOT_PATH . '/config/routes.php';
        $router = new Router($routes, $this->config);
        $router->dispatch();
    }
}
