<?php

namespace App\Enum;

enum ComplaintCategoryEnum:string
{
    case billing = "billing";
    case service_issue = "service_issue";
    case product_issue = "product_issue";


    public static function all(): array
    {
        return [
            self::billing->value,
            self::service_issue->value,
            self::product_issue->value,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::billing => "Billing",
            self::service_issue => "Service Issue",
            self::product_issue => "Product Issue",
        };
    }
}
