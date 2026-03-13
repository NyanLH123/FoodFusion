<?php
namespace app\core;

class Session {
    public static function init() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function has($key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public static function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    public static function destroy() {
        $_SESSION = [];
        if (session_status() !== PHP_SESSION_NONE) {
            session_destroy();
        }
    }

    
    public static function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return (string)$_SESSION['csrf_token'];
    }

    public static function verifyCsrfToken($token): bool
    {
        $stored = $_SESSION['csrf_token'] ?? null;
        if (!is_string($stored) || !is_string($token)) {
            return false;
        }
        return hash_equals($stored, $token);
    }

    public static function regenerateCsrfToken(): void
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}