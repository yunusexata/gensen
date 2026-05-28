<?php

namespace App\Imports;

use App\Models\GensenForm\GensenForm;
use App\Repositories\GensenForm\GensenFormRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImportTarikData implements ToCollection, WithHeadingRow, WithChunkReading
{
    public $rows;

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $value) {
            $data = GensenForm::select(
                'gensen_forms.id_customer'
            )
                ->where('no_input_jepang', $value['no_input_jepang'])
                ->where('nama_lengkap', $value['nama_lengkap'])
                ->join('gensen_form_details as gfd', function ($j) use ($value) {
                    $j->on('gfd.gensen_form_id', '=', 'gensen_forms.id')
                        ->where('gfd.tahun_gensen', trim($value['tahun_gensen']));
                })
                ->first();
            logger([
                'data export dalam pengajuan query',
                $data
            ]);
            if ($data) {
                $this->rows[] =
                    [
                        // From DB Query
                        'id_customer' => $data['id_customer'],
                        'nomor_whatsapp' => $data['nomor_whatsapp'],
                        'nomor_whatsapp_darurat' => $data['nomor_whatsapp_darurat'],

                        // From Excel
                        'nama_lengkap' => $value['nama_lengkap'],
                        'tgl_lahir' => $value['tgl_lahir'],
                        'nominal_gensen' => $value['nominal_gensen'],
                        'tahun_gensen' => $value['tahun_gensen'],
                        'no_input_jepang' => $value['no_input_jepang'],
                        'tanggal_tarik_data' => $value['tanggal_tarik_data'],
                        'label' => $value['label'],
                        'status' => $value['status'],
                        'keterangan' => $value['keterangan'],
                        'jumlah_kirim_uang' => $value['jumlah_kirim_uang'],
                        'hubungan_keluarga' => $value['hubungan_keluarga'],
                    ];
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
