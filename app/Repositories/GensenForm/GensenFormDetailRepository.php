<?php

namespace App\Repositories\GensenForm;

use App\Enums\Gensen\GensenFormDetailStatus;
use App\Models\Gensen\Ai\RemittanceExtraction;
use App\Models\Gensen\Ai\RemittanceExtractionGroup;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormDetail;
use App\Repositories\MasterDataRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GensenFormDetailRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenFormDetail::class;
    }

    public static function rollback($gensen_form_detail_id, $status)
    {
        DB::beginTransaction();

        try {

            $gensen_form_detail = self::find($gensen_form_detail_id);

            $gensen_form = $gensen_form_detail->gensenForm;
            /*
        |--------------------------------------------------------------------------
        | 1. CREATE NEW FORM
        |--------------------------------------------------------------------------
        */
            $newForm = GensenFormRepository::create([
                'id_customer' => $gensen_form->id_customer,
                'status' => $status,
                'nama_lengkap' => $gensen_form->nama_lengkap,
                'tanggal_lahir' => $gensen_form->tanggal_lahir,
                'tanggal_kepulangan' => $gensen_form->tanggal_kepulangan,
                'nama_instagram' => $gensen_form->nama_instagram,
                'nama_tiktok' => $gensen_form->nama_tiktok,
                'nomor_whatsapp' => $gensen_form->nomor_whatsapp,
                'nomor_whatsapp_darurat' => $gensen_form->nomor_whatsapp_darurat,
                'email' => $gensen_form->email,
                'alamat_jepang' => $gensen_form->alamat_jepang,
                'kode_pos_jepang' => $gensen_form->kode_pos_jepang,
                'nama_lpk' => $gensen_form->nama_lpk,

                'no_rekening_penerima' => $gensen_form->no_rekening_penerima,
                'nama_bank_penerima' => $gensen_form->nama_bank_penerima,
                'nama_penerima' => $gensen_form->nama_penerima,
                'hubungan_penerima' => $gensen_form->hubungan_penerima,

                // 'tahun_gensen' => $gensen_form->tahun_gensen,
                // 'tahun_transfer' => $gensen_form->tahun_transfer,

                'remarks_id' => $gensen_form->remarks_id,
                'remarks_type' => $gensen_form->remarks_type,
                'pic_code' => $gensen_form->pic_code,
                'no_input_jepang' => $gensen_form->no_input_jepang,

                'is_should_filled' => true,
                'is_submitted' => true,
            ]);

            /*
        |--------------------------------------------------------------------------
        | 2. COPY ATTACHMENTS
        |--------------------------------------------------------------------------
        */

            $attachments = $gensen_form->attachmentsCopy;

            foreach ($attachments as $attachment) {

                $disk = $attachment->disk;

                if (!Storage::disk($disk)->exists($attachment->path)) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Generate NEW FILE PATH
                |--------------------------------------------------------------------------
                */

                $extension = $attachment->extension;
                $newStoredName = Str::uuid() . '.' . $extension;

                $newPath = "gensen/{$newForm->id}/{$attachment->type->value}/{$newStoredName}";

                /*
                |--------------------------------------------------------------------------
                | Copy File (Driver Safe)
                |--------------------------------------------------------------------------
                */

                $sourceDisk = Storage::disk($disk);

                // stream prevents memory explosion + works for S3/Supabase/local
                $stream = $sourceDisk->readStream($attachment->path);

                if ($stream === false) {
                    continue;
                }

                Storage::disk($disk)->writeStream($newPath, $stream);

                if (is_resource($stream)) {
                    fclose($stream);
                }


                /*
                |--------------------------------------------------------------------------
                | Create New Attachment Row
                |--------------------------------------------------------------------------
                */

                GensenFormAttachmentRepository::create([
                    'gensen_form_id' => $newForm->id,
                    'type' => $attachment->type,
                    'original_name' => $attachment->original_name,
                    'stored_name' => $newStoredName,
                    'description' => $attachment->description,

                    'disk' => $disk,
                    'path' => $newPath,
                    'note' => $attachment->note,
                    'remittance_type' => $attachment->remittance_type,

                    'extension' => $attachment->extension,
                    'mime_type' => $attachment->mime_type,
                    'file_size' => $attachment->file_size,

                    'checksum' => $attachment->checksum,
                    'status' => $attachment->status,
                    'convert_image' => $attachment->convert_image,
                ]);
            }

            $detail = $gensen_form->gensenFormDetails()->where('id', $gensen_form_detail_id)->first();
            if ($detail) {
                GensenFormDetailRepository::create(
                    [
                        'gensen_form_id' => $newForm->id,
                        'tahun_gensen' => $detail['tahun_gensen'],
                        'nominal_gensen' => $detail['nominal_gensen'],

                        // Step 4 - Acc Exata
                        'tanggal_tarik_data' => $detail['tanggal_tarik_data'],  // Tanggal Tarik Data
                        'label' => $detail['label'],  // Label Tarik Data

                        // Step 5 - HS2
                        'nominal_cair' => $detail['nominal_cair'],
                        'tanggal_cair' => $detail['tanggal_cair'],

                        'status' => GensenFormDetailStatus::VALID,
                        'keterangan' => $detail['keterangan'],
                    ]
                );
            }
            $remittanceExtraction = $gensen_form->remittanceExtraction;
            if ($remittanceExtraction) {
                $remittance = RemittanceExtraction::create(
                    [
                        'ai_job_id' => $remittanceExtraction->ai_job_id,
                        'subject_id' => $newForm->id,
                        'subject_type' => GensenForm::class,
                        'confidence_score' => $remittanceExtraction->confidence_score,
                        'confidence_note' => $remittanceExtraction->confidence_note,
                        'total_transfer' => $remittanceExtraction->total_transfer,
                        'ai_total_transfer' => $remittanceExtraction->ai_total_transfer,
                    ]
                );
                foreach ($remittanceExtraction->remittanceExtractionGroups as $data) {
                    if (toReiwaYear($data->transaction_year) == $gensen_form_detail->tahun_gensen) {
                        RemittanceExtractionGroup::create(
                            [
                                'remittance_extraction_id' => $remittance->id,
                                'receiver_name' => $data->receiver_name,
                                'transaction_year' => $data->transaction_year,
                                'total_amount' => $data->total_amount,
                                'amount_details' => $data->amount_details,
                                'currency' => $data->currency,
                                'is_validate' => $data->is_validate,
                                'transfer_transaction_count' => $data->transfer_transaction_count,
                            ]
                        );
                    }
                }
            }
            DB::commit();

            return $newForm;
        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
