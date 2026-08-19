<?php

namespace App\Livewire\GensenForm\GensenData;

use App\Enums\Gensen\GensenAttachmentType;
use App\Helpers\Alert;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormLink;
use App\Models\User;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $objId;

    #[Validate('required', message: 'Nama Harus Diisi', onUpdate: false)]
    public $nama_lengkap;
    #[Validate('required', message: 'Tanggal Lahir Harus Diisi', onUpdate: false)]
    public $tanggal_lahir;

    public $tanggal_kepulangan;
    public $nama_instagram;
    public $nama_tiktok;
    public $nomor_whatsapp;
    public $nomor_whatsapp_darurat;
    public $email;
    public $alamat_jepang;
    public $kode_pos_jepang;
    public $nama_lpk;

    // REK PENERIMA
    public $no_rekening_penerima;
    public $nama_bank_penerima;
    public $nama_penerima;

    public $status;
    public $tahun_gensen;
    public $tahun_transfer;

    // UPLOAD 
    public $kertas_gensen;
    public $my_number_front;
    public $my_number_back;
    public $zairyou_card_front;
    public $zairyou_card_back;
    public $kartu_keluarga;
    public $rekap_pengiriman_uang;
    public $rekening_indonesia;

    // UPLOAD OLD
    public $kertas_gensen_old;
    public $my_number_front_old;
    public $my_number_back_old;
    public $zairyou_card_front_old;
    public $zairyou_card_back_old;
    public $kartu_keluarga_old;
    public $rekap_pengiriman_uang_old;
    public $rekening_indonesia_old;

    public function mount() {}

    #[On('on-dialog-confirm')]
    public function onDialogConfirm() {}

    #[On('on-dialog-cancel')]
    public function onDialogCancel() {}


    public function addRekapPengirimanUang()
    {
        $this->rekap_pengiriman_uang[] = [
            'file' => [],
            'type' => null
        ];
    }
    protected function attachmentInputs(): array
    {
        return [
            [
                'type' => GensenAttachmentType::KERTAS_GENSEN,
                'file' => $this->kertas_gensen,
            ],
            [
                'type' => GensenAttachmentType::MY_NUMBER_FRONT,
                'file' => $this->my_number_front,
            ],
            [
                'type' => GensenAttachmentType::MY_NUMBER_BACK,
                'file' => $this->my_number_back,
            ],
            [
                'type' => GensenAttachmentType::ZAIRYOU_CARD_FRONT,
                'file' => $this->zairyou_card_front,
            ],
            [
                'type' => GensenAttachmentType::ZAIRYOU_CARD_BACK,
                'file' => $this->zairyou_card_back,
            ],
            [
                'type' => GensenAttachmentType::KARTU_KELUARGA,
                'file' => $this->kartu_keluarga,
            ],
            [
                'type' => GensenAttachmentType::REKAP_PENGIRIMAN_UANG,
                'file' => $this->rekap_pengiriman_uang,
            ],
            [
                'type' => GensenAttachmentType::REKENING_INDONESIA,
                'file' => $this->rekening_indonesia,
            ],
        ];
    }
    public function store()
    {
        $this->validate();
        try {
            DB::transaction(function () {
                $id = simple_decrypt($this->objId);
                if (!$id) {
                    abort(404, 'Link tidak valid atau telah dimanipulasi.');
                }
                $form = GensenFormLinkRepository::findBy([
                    ['token', $id]
                ]);
                // Form Candidate
                $validateData = [
                    // Form J-Expert
                    'nama_lengkap' => $this->nama_lengkap,
                    'tanggal_lahir' => $this->tanggal_lahir,
                    'tanggal_kepulangan' => $this->tanggal_kepulangan,
                    'nama_facebook' => $this->nama_facebook,
                    'nomor_whatsapp' => $this->nomor_whatsapp,
                    'nomor_whatsapp_darurat' => $this->nomor_whatsapp_darurat,
                    'email' => $this->email,
                    'alamat_jepang' => $this->alamat_jepang,
                    'kode_pos_jepang' => $this->kode_pos_jepang,
                    'nama_lpk' => $this->nama_lpk,

                    // REK PENERIMA
                    'no_rekening_penerima' => $this->no_rekening_penerima,
                    'nama_bank_penerima' => $this->nama_bank_penerima,
                    'nama_penerima' => $this->nama_penerima,

                    'tahun_gensen' => $this->tahun_gensen,
                    'tahun_transfer' => $this->tahun_transfer,

                    'remarks_id' => Auth::user()->id,
                    'remarks_type' => User::class,
                    'pic_code' => Auth::user()->pic_code,
                ];

                $gensenForm = GensenFormRepository::create($validateData);
                $this->storeAttachments($gensenForm);
            });


            DB::commit();
            Alert::confirmation(
                $this,
                Alert::ICON_SUCCESS,
                "Berhasil",
                "Data Berhasil Diperbarui",
                "on-dialog-confirm",
                "on-dialog-cancel",
                "Oke",
                "Tutup",
            );
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }
    protected function storeAttachments(GensenForm $gensenForm): void
    {
        DB::transaction(function () use ($gensenForm) {

            foreach ($this->attachmentInputs() as $input) {

                $type = $input['type'];
                $files = $input['file'];


                if (!$files) {
                    continue;
                }

                // normalize jadi array
                $files = is_array($files) ? $files : [$files];

                foreach ($files as $file) {
                    if ($type === GensenAttachmentType::REKAP_PENGIRIMAN_UANG) {
                        foreach ($file['file'] as $item) {
                            $filePath = "gensen/{$gensenForm->id}/{$type->value}/" . $file['type'];
                            $this->handleGensenFormAttachemntStore($item, $type, $gensenForm, $filePath, $file['type']);
                        }
                    } else {
                        $this->handleGensenFormAttachemntStore($file, $type, $gensenForm);
                    }
                }
            }
        });
    }

    private function handleGensenFormAttachemntStore($file, $type, $gensenForm, $path = null, $note = null)
    {
        $storedName = Str::uuid() . '.' . $file->extension();

        $filePath = $path ? $path :  "gensen/{$gensenForm->id}/{$type->value}";
        $path = $file->storeAs(
            $filePath,
            $storedName,
            'private'
        );

        GensenFormAttachmentRepository::create([
            'gensen_form_id' => $gensenForm->id,

            'type' => $type,
            'disk' => 'private',
            'path' => $path,
            'note' => $note,

            'original_name' => $file->getClientOriginalName(),
            'stored_name' => $storedName,

            'extension' => $file->extension(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),

            'checksum' => hash_file('sha256', $file->getRealPath()),

            'uploaded_by' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.gensen-form.gensen-data.create');
    }
}
