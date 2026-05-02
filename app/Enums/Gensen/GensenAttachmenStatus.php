<?php

namespace App\Enums\Gensen;

enum GensenAttachmenStatus: string
{
    case STATUS_STORED = 'stored';
    case STATUS_REJECTED = 'rejected';
    case STATUS_EDITED = 'edited';

    public function label(): string
    {
        return match ($this) {
            self::STATUS_STORED => 'STORED',
            self::STATUS_REJECTED => 'REJECTED',
            self::STATUS_EDITED => 'EDITED',
        };
    }
    public function print(): string
    {
        return match ($this) {
            self::STATUS_STORED => '<span class="btn btn-sm btn-warning">' . $this->label() . '</span>',
            self::STATUS_REJECTED => '<span class="btn btn-sm btn-danger">' . $this->label() . '</span>',
            self::STATUS_EDITED => '<span class="btn btn-sm btn-success">' . $this->label() . '</span>',
        };
    }

    public function is(self $status): bool
    {
        return $this === $status;
    }

    /** ⭐ for select option */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [
                $case->value => $case->label(),
            ])
            ->toArray();
    }
}
