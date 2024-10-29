<?php

namespace App\Enum;

enum ComplaintPriorityEnum:string
{
    case low = "low";
    case medium = "medium";
    case high = "high";


    public static function all(): array
    {
        return [
            self::low->value,
            self::medium->value,
            self::high->value,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::low => "Low",
            self::medium => "Medium",
            self::high => "High",
        };
    }
}
