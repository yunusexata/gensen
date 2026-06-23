<?php

namespace App\Repositories\ResiGenerator;

use App\Models\ResiGenerator\ResiGeneratorDetail;
use App\Repositories\MasterDataRepository;

class ResiGeneratorDetailRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return ResiGeneratorDetail::class;
    }

    public static function datatable($objId = null)
    {
        return ResiGeneratorDetail::query()
            ->leftJoin(
                'resi_generator_emails',
                'resi_generator_emails.id',
                '=',
                'resi_generator_details.resi_generator_email_id'
            )
            ->when($objId, function ($q) use ($objId) {
                $q->where(
                    'resi_generator_details.resi_generator_id',
                    $objId
                );
            })
            ->select(
                'resi_generator_details.*',
                'resi_generator_emails.formatted_nominal',
                'resi_generator_emails.formatted_penerima',
                'resi_generator_emails.formatted_rekening_tujuan'
            );
    }
}
