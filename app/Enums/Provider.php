<?php

namespace App\Enums;

enum Provider
{
    case NewsApi;
    case Guardian;
    case NewsDataIO;

    public static function values(): array
    {
        return array_map(fn ($case) => $case->name, self::cases());
    }
}