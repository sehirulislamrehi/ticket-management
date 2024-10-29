<?php

namespace App\Enum;

enum ComplaintStatusEnum:string
{
    case open = "open";
    case in_progress = "in_progress";
    case resolved = "resolved";
    case closed = "closed";


    public static function all(): array
    {
        return [
            self::open->value,
            self::in_progress->value,
            self::resolved->value,
            self::closed->value,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::open => "Open",
            self::in_progress => "In Progress",
            self::resolved => "Resolved",
            self::closed => "Closed",
        };
    }
}
