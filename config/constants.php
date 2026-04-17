<?php
declare(strict_types=1);

define('APP_NAME', 'FoodFusion');
define('APP_ENV', getenv('APP_ENV') ?: 'development');
define('APP_DEBUG', APP_ENV !== 'production');
define('APP_TIMEZONE', 'Asia/Rangoon');

define('BASE_PATH', realpath(__DIR__ . '/..'));

$docRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '';
$baseUrl = '';
$normalizedBasePath = str_replace('\\', '/', BASE_PATH);
$normalizedDocRoot = str_replace('\\', '/', $docRoot);

if ($normalizedDocRoot !== '' && str_starts_with(strtolower($normalizedBasePath), strtolower($normalizedDocRoot))) {
    $relative = substr($normalizedBasePath, strlen($normalizedDocRoot));
    $baseUrl = is_string($relative) ? $relative : '';
}
define('BASE_URL', rtrim($baseUrl, '/'));

define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'foodfusion');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

define('MAX_UPLOAD_IMAGE', 2 * 1024 * 1024);
define('MAX_UPLOAD_FILE', 8 * 1024 * 1024);
