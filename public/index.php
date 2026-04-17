<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

$appConfig = require ROOT_PATH . '/config/app.php';
date_default_timezone_set((string) ($appConfig['timezone'] ?? 'UTC'));

spl_autoload_register(static function (string $class): void {
    $paths = [
        ROOT_PATH . '/app/core/' . $class . '.php',
        ROOT_PATH . '/app/controllers/' . $class . '.php',
        ROOT_PATH . '/app/models/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (is_file($path)) {
            require_once $path;
            return;
        }
    }
});

Session::start();

$app = new App($appConfig);
$app->run();
