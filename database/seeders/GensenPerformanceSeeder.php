<?php

namespace Database\Seeders;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormAttachment;
use App\Models\GensenForm\GensenFormLink;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GensenPerformanceSeeder extends Seeder
{
    // CCD00131
    private string $exampleDisk = 'public';
    private string $examplePath = 'example';

    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $fakerJp = Faker::create('ja_jp');

        $total = 500; // 🔥 change for performance testing

        $users = User::role(User::ROLE_SALES)->get();

        for ($i = 0; $i < $total; $i++) {
            $this->command->info('Gensen Forms seeded successfully  ' . $i);
            /*
            |--------------------------------------------------------------------------
            | OWNER SOURCE
            |--------------------------------------------------------------------------
            */
            $owner = $users->random();
            $pic_code = $owner->pic_code;
            $count = 1;
            if (rand(0, 1)) {
                $remarksType = User::class;
                $remarksId = $owner->id;
            } else {

                $count = rand(0, 2);
                $link = GensenFormLink::create([
                    'pic_code' => $pic_code,
                    'name' => 'Link ' . $faker->name(),
                    'password' => bcrypt('secret'),
                    'max_usage' => rand(1, 5),
                    'used_count' => $count,
                    'expired_at' => now()->addDays(rand(5, 60)),
                    'status' => 'ACTIVE',
                    'created_by' => $users->random()->id,
                ]);

                $remarksType = GensenFormLink::class;
                $remarksId = $link->id;
            }

            for ($j = 0; $j < $count; $j++) {

                /*
                |--------------------------------------------------------------------------
                | CREATE FORM
                |--------------------------------------------------------------------------
                */
                $form = GensenForm::create([
                    'nama_lengkap' => $faker->name(),
                    'tanggal_lahir' => $faker->date(),
                    'tanggal_kepulangan' => $faker->date(),
                    'nama_instagram' => "@" . $faker->userName(),
                    'nama_tiktok' => "@" . $faker->userName(),
                    'nomor_whatsapp' => '08' . $faker->numerify('##########'),
                    'nomor_whatsapp_darurat' => '08' . $faker->numerify('##########'),
                    'email' => $faker->safeEmail(),

                    'alamat_jepang' => $fakerJp->address(),
                    'kode_pos_jepang' => $fakerJp->postcode(),
                    'nama_lpk' => 'LPK ' . $fakerJp->company(),

                    'no_rekening_penerima' => $faker->bankAccountNumber(),
                    'nama_bank_penerima' => $faker->randomElement([
                        'BCA',
                        'MANDIRI',
                        'BNI',
                        'BRI',
                    ]),
                    'nama_penerima' => $faker->name(),
                    'hubungan_penerima' => $faker->randomElement([
                        'Ayah',
                        'Ibu',
                        'Istri',
                        'Suami',
                        'Anak',
                        'Saudara',
                    ]),

                    // 'status' => $faker->randomElement([
                    //     GensenForm::STATUS_BELUM_LENGKAP,
                    //     GensenForm::STATUS_LENGKAP,
                    //     GensenForm::STATUS_VERIFIED,
                    //     GensenForm::STATUS_GENSEN_CAIR,
                    //     GensenForm::STATUS_CANCEL,
                    //     GensenForm::STATUS_HONNIN,
                    // ]),

                    'tahun_gensen' => rand(5, 7),
                    'tahun_transfer' => rand(2020, 2025),

                    'remarks_type' => $remarksType,
                    'remarks_id' => $remarksId,

                    'pic_code' => $pic_code,
                    'is_should_filled' => true,
                    'is_submitted' => rand(0, 1),
                ]);

                /*
                |--------------------------------------------------------------------------
                | ATTACHMENTS
                |--------------------------------------------------------------------------
                */
                $this->seedAttachments($form);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ATTACHMENT SEEDER
    |--------------------------------------------------------------------------
    */
    private function seedAttachments(GensenForm $form): void
    {
        $files = [
            'kartu_keluarga' => [
                'kartu_keluarga_1.pdf',
                'kartu_keluarga_2.pdf'
            ],
            'kertas_gensen' => ['kertas_gensen.pdf'],
            'rekap_pengiriman_uang' => [
                'rekapan_1.pdf',
                'rekapan_2.pdf',
                'rekapan_3.pdf'
            ],
            'zairyou_front' => ['zairyou_front.jpg'],
            'zairyou_back' => ['zairyou_back.jpg'],
            'my_number_front' => ['my_number_front.jpg'],
            'my_number_back' => ['my_number_back.jpg'],
            'rekening_indonesia' => ['rekening_indonesia.jpg'],
        ];

        $faker = Faker::create();

        foreach ($files as $type => $candidates) {

            // simulate missing upload
            if (rand(0, 1) === 0) {
                continue;
            }

            $source = collect($candidates)->random();

            $storedName = Str::uuid() . '.' . pathinfo($source, PATHINFO_EXTENSION);
            $examplePath = "example/{$source}";

            $fullPath = Storage::disk('private')->path($examplePath);

            GensenFormAttachment::create([
                'gensen_form_id' => $form->id,
                'type' => $type,
                'original_name' => $source,
                'stored_name' => $storedName,
                'disk' => 'private',
                'path' => $examplePath,
                'extension' => pathinfo($source, PATHINFO_EXTENSION),
                'mime_type' => mime_content_type($fullPath),
                'file_size' => filesize($fullPath),
                'checksum' => md5_file($fullPath),
                'status' => $faker->randomElement(GensenAttachmenStatus::cases()),
                'description' => null,
                'note' => null,
                'remittance_type' => null,
            ]);
        }
    }
}
