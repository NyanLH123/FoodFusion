<?php

declare(strict_types=1);

class Auth
{
    private const SESSION_KEY = '_auth_user';

    public static function login(array $user): void
    {
        session_regenerate_id(true);
        Session::set(self::SESSION_KEY, $user);
    }

    public static function logout(): void
    {
        Session::remove(self::SESSION_KEY);
    }

    public static function check(): bool
    {
        return Session::has(self::SESSION_KEY);
    }

    public static function user(): ?array
    {
        return Session::get(self::SESSION_KEY);
    }

    public static function isAdmin(): bool
    {
        $user = self::user();
        return $user !== null && (int) ($user['role'] ?? 0) === 1;
    }

    public static function id(): ?int
    {
        $user = self::user();
        return $user !== null ? (int) $user['userId'] : null;
    }

    public static function syncUser(array $user): void
    {
        Session::set(self::SESSION_KEY, $user);
    }
}
