<?php

namespace App\Helpers;

class ConsentHelper
{
    public static function get(): array
    {
        $cookie = request()->cookie('cookie_consent');

        if (!$cookie) {
            return [
                'necessary'   => true,
                'analytics'   => false,
                'marketing'   => false,
                'preferences' => false,
            ];
        }

        $data = is_string($cookie) ? json_decode($cookie, true) : $cookie;

        return [
            'necessary'   => true,
            'analytics'   => (bool) ($data['analytics'] ?? false),
            'marketing'   => (bool) ($data['marketing'] ?? false),
            'preferences' => (bool) ($data['preferences'] ?? false),
        ];
    }

    public static function has(string $category): bool
    {
        return self::get()[$category] ?? false;
    }
}
