<?php

namespace App\Enums\Gensen;

enum GensenBank: string
{
    case BCA = 'BCA';
    case MANDIRI = 'MANDIRI';
    case BRI = 'BRI';
    case BNI = 'BNI';
    /** ⭐ for select option */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [
                $case->value => $case->value,
            ])
            ->toArray();
    }
}
