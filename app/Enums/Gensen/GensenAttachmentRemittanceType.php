<?php

namespace App\Enums\Gensen;

enum GensenAttachmentRemittanceType: string
{
    case REMITTANCE_NOT_REKAP_PENGIRIMAN = '';
    case REMITTANCE_SMILES = 'SMILES';
    case REMITTANCE_KYODAI = 'KYODAI';
    case REMITTANCE_RIA_KYODAI = 'RIA KYODAI';
    case REMITTANCE_CITY_EXPRESS = 'CITY EXPRESS';
    case REMITTANCE_SBI = 'SBI';
    case REMITTANCE_DCOM = 'DCOM';
    case REMITTANCE_LAINNYA = 'LAINNYA';

    public function label(): string
    {
        return match ($this) {
            self::REMITTANCE_NOT_REKAP_PENGIRIMAN => '-- ISI --',
            self::REMITTANCE_SMILES => 'SMILES',
            self::REMITTANCE_KYODAI => 'KYODAI',
            self::REMITTANCE_RIA_KYODAI => 'RIA KYODAI',
            self::REMITTANCE_CITY_EXPRESS => 'CITY EXPRESS',
            self::REMITTANCE_SBI => 'SBI',
            self::REMITTANCE_DCOM => 'DCOM',
            self::REMITTANCE_LAINNYA => 'LAINNYA',
        };
    }

    public function is(self $remittance_type): bool
    {
        return $this === $remittance_type;
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
