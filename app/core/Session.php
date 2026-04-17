<?php

declare(strict_types=1);

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $savePath = self::resolveWritableSavePath();
            if ($savePath !== null) {
                session_save_path($savePath);
            }
            session_start();
        }
    }

    private static function resolveWritableSavePath(): ?string
    {
        $configured = (string) ini_get('session.save_path');
        $path = self::extractSessionPath($configured);

        if ($path !== '' && is_dir($path) && is_writable($path)) {
            return $path;
        }

        $projectPath = ROOT_PATH . '/storage/sessions';
        if (!is_dir($projectPath) && !mkdir($projectPath, 0775, true) && !is_dir($projectPath)) {
            $projectPath = '';
        }

        if ($projectPath !== '' && is_writable($projectPath)) {
            return $projectPath;
        }

        $temp = sys_get_temp_dir();
        return (is_dir($temp) && is_writable($temp)) ? $temp : null;
    }

    private static function extractSessionPath(string $savePath): string
    {
        // Some setups use "N;/path" (N = directory depth). Keep only the final path segment.
        if (str_contains($savePath, ';')) {
            $parts = explode(';', $savePath);
            return trim((string) end($parts));
        }
        return trim($savePath);
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        session_unset();
        session_destroy();
    }

    // Flash: write once, read once
    public static function flash(string $key, string $message): void
    {
        $_SESSION['_flash'][$key] = $message;
    }

    public static function getFlash(string $key): ?string
    {
        $value = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $value;
    }
}
