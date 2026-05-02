<?php

namespace App\Enums\Gensen;

enum GensenAttachmentType: string
{
    case KERTAS_GENSEN = 'kertas_gensen';
    case REKAP_PENGIRIMAN_UANG = 'rekap_pengiriman_uang';
    case KARTU_KELUARGA = 'kartu_keluarga';
    case ZAIRYOU_CARD_FRONT = 'zairyou_front';
    case ZAIRYOU_CARD_BACK = 'zairyou_back';
    case MY_NUMBER_FRONT = 'my_number_front';
    case MY_NUMBER_BACK = 'my_number_back';
    case REKENING_INDONESIA = 'rekening_indonesia';
    case PERSYARATAN_PENGURUSAN_GENSEN = 'persyaratan_pengurusan_gensen';
    case SELURUH_BERKAS = 'seluruh_berkas';

    public function label(): string
    {
        return match ($this) {
            self::KERTAS_GENSEN => 'Kertas Gensen',
            self::REKAP_PENGIRIMAN_UANG => 'Rekap Pengiriman Uang',
            self::KARTU_KELUARGA => 'Kartu Keluarga',
            self::ZAIRYOU_CARD_FRONT => 'Zairyou Card Depan',
            self::ZAIRYOU_CARD_BACK => 'Zairyou Card Belakang',
            self::MY_NUMBER_FRONT => 'My Number Depan',
            self::MY_NUMBER_BACK => 'My Number Belakang',
            self::REKENING_INDONESIA => 'Rekening Indonesia',
            self::PERSYARATAN_PENGURUSAN_GENSEN => 'Persyaratan Pengurusan Gensen',
            self::SELURUH_BERKAS => 'Seluruh Berkas',
        };
    }
    public static function mergeIdentity(): array
    {
        return [
            self::ZAIRYOU_CARD_FRONT,
            self::ZAIRYOU_CARD_BACK,
            self::MY_NUMBER_FRONT,
            self::MY_NUMBER_BACK,
            self::REKENING_INDONESIA,
        ];
    }

    public static function mergeAllIdentity(): array
    {
        return [
            self::KERTAS_GENSEN,
            self::PERSYARATAN_PENGURUSAN_GENSEN,
            self::REKAP_PENGIRIMAN_UANG,
            self::KARTU_KELUARGA,
        ];
    }
    public static function completeIdentity(): array
    {
        return [
            self::KERTAS_GENSEN,
            self::REKAP_PENGIRIMAN_UANG,
            self::KARTU_KELUARGA,
            self::ZAIRYOU_CARD_FRONT,
            self::ZAIRYOU_CARD_BACK,
            self::MY_NUMBER_FRONT,
            self::MY_NUMBER_BACK,
            self::REKENING_INDONESIA,
        ];
    }

    public static function fromLabel(string $label): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->label() === $label) {
                return $case;
            }
        }

        return null;
    }

    public function isGenerated(): bool
    {
        return match ($this) {
            self::PERSYARATAN_PENGURUSAN_GENSEN => true,
            default => false,
        };
    }

    public function is(self $type): bool
    {
        return $this === $type;
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
