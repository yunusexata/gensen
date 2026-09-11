<?php

namespace App\Enums\Gensen;

enum GensenFormDetailStatus: string
{
    case PROCESS = '';
    case VALID = 'valid';
    case SUCCESS = 'success';
    case CANCEL = 'cancel';
    case ROLLBACK = 'rollback';

    public function label(): string
    {
        return match ($this) {
            self::VALID => 'valid',
            self::SUCCESS => 'success',
            self::CANCEL => 'cancel',
            self::ROLLBACK => 'rollback',
        };
    }
}
