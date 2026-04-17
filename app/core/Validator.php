<?php

declare(strict_types=1);

class Validator
{
    /**
     * Return an array of error messages for any required fields that are empty.
     * Keys are field names, values are human-readable messages.
     */
    public static function required(array $data, array $fields): array
    {
        $errors = [];
        foreach ($fields as $field) {
            $value = trim((string) ($data[$field] ?? ''));
            if ($value === '') {
                $label = ucfirst(str_replace(['_', '-'], ' ', $field));
                $errors[$field] = "{$label} is required.";
            }
        }
        return $errors;
    }

    public static function email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function minLength(string $value, int $min): bool
    {
        return mb_strlen($value) >= $min;
    }

    public static function maxLength(string $value, int $max): bool
    {
        return mb_strlen($value) <= $max;
    }
}
