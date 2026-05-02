<?php

namespace App\Livewire\GensenForm\GensenData;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentRemittanceType;
use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormAttachment;
use App\Models\User;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use App\Repositories\GensenForm\PersyaratanGensenJobRepository;
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

class Attachment extends Component
{
    use WithFileUploads;

    public $objId;
    public $targetDeleteId;
    public $isCanDelete;

    #[Validate('required', message: 'Nama Harus Diisi', onUpdate: false)]
    public $nama_lengkap;
    #[Validate('required', message: 'Tanggal Lahir Harus Diisi', onUpdate: false)]
    public $tanggal_lahir;
    #[Validate('required', message: 'Tanggal Lahir Harus Diisi', onUpdate: false)]
    public $nomor_whatsapp;

    // UPLOAD 
    public $kertas_gensen;
    public $my_number_front;
    public $my_number_back;
    public $zairyou_card_front;
    public $zairyou_card_back;
    public $kartu_keluarga;
    public $rekap_pengiriman_uang;
    public $rekening_indonesia;

    public $seluruh_berkas_old;
    public $persyaratan_pengurusan_gensen_old;
    public $kertas_gensen_old;
    public $my_number_front_old;
    public $my_number_back_old;
    public $zairyou_card_front_old;
    public $zairyou_card_back_old;
    public $kartu_keluarga_old;
    public $rekap_pengiriman_uang_old;
    public $rekening_indonesia_old;

    // Edited Data
    public $editedData = [
        'id' => false,
        'type' => null,
        'src' => null,
    ];
    // Show PDF Data
    public $showData = [
        'id' => null,
        'type' => null,
        'url' => null,
        'file_name' => null,
        'created_at' => null,
    ];

    public $photo;

    public function mount()
    {
        $this->getData();
    }

    private function getData()
    {

        if ($this->objId) {
            $gensen = GensenFormRepository::find(Crypt::decrypt($this->objId));
            $this->nama_lengkap = $gensen->nama_lengkap;
            $this->tanggal_lahir = $gensen->tanggal_lahir;
            $this->nomor_whatsapp = $gensen->nomor_whatsapp;

            $attachments = $gensen->attachmentGroups();
            // dd($attachments);
            $this->kertas_gensen_old = $attachments[GensenAttachmentType::KERTAS_GENSEN->value];
            $this->my_number_front_old = $attachments[GensenAttachmentType::MY_NUMBER_FRONT->value];
            $this->my_number_back_old = $attachments[GensenAttachmentType::MY_NUMBER_BACK->value];
            $this->zairyou_card_front_old = $attachments[GensenAttachmentType::ZAIRYOU_CARD_FRONT->value];
            $this->zairyou_card_back_old = $attachments[GensenAttachmentType::ZAIRYOU_CARD_BACK->value];
            $this->kartu_keluarga_old = $attachments[GensenAttachmentType::KARTU_KELUARGA->value];
            $this->rekap_pengiriman_uang_old = $attachments[GensenAttachmentType::REKAP_PENGIRIMAN_UANG->value];
            $this->rekening_indonesia_old = $attachments[GensenAttachmentType::REKENING_INDONESIA->value];
            $this->persyaratan_pengurusan_gensen_old = $attachments[GensenAttachmentType::PERSYARATAN_PENGURUSAN_GENSEN->value];
            $this->seluruh_berkas_old = $attachments[GensenAttachmentType::SELURUH_BERKAS->value];
            $this->isCanDelete = $gensen->isCanDelete();
        }
    }
    private function getDataGenerated()
    {

        if ($this->objId) {
            $gensen = GensenFormRepository::find(Crypt::decrypt($this->objId));

            $attachments = $gensen->attachmentGroups();
            $this->persyaratan_pengurusan_gensen_old = $attachments[GensenAttachmentType::PERSYARATAN_PENGURUSAN_GENSEN->value];
            $this->seluruh_berkas_old = $attachments[GensenAttachmentType::SELURUH_BERKAS->value];
        }
    }
    public function refreshData()
    {
        consoleLog($this, 'refresh data brok');
        if (
            !$this->seluruh_berkas_old['isJobProcessDone']
            || !$this->persyaratan_pengurusan_gensen_old['isJobProcessDone']
        ) {
            $this->getDataGenerated();
        }
    }

    public function showDialogDeleteFile($id)
    {
        $this->targetDeleteId = $id;
        Alert::confirmation(
            $this,
            Alert::ICON_QUESTION,
            "Hapus Data",
            "Apakah Anda Yakin Ingin Menghapus Data Ini ?",
            "on-delete-dialog-file-confirm",
            "on-delete-dialog-file-cancel",
            "Hapus",
            "Batal",
        );
    }

    #[On('on-delete-dialog-file-cancel')]
    public function onDialogDeleteFileCancel()
    {
        $this->targetDeleteId = null;
    }
    #[On('on-delete-dialog-file-confirm')]
    public function onDialogDeleteFileConfirm()
    {
        if (!$this->isCanDelete && $this->targetDeleteId != null) {
            $data = GensenFormAttachmentRepository::update(Crypt::decrypt($this->targetDeleteId), [
                'status' => GensenAttachmenStatus::STATUS_REJECTED
            ]);
        } elseif ($this->isCanDelete && $this->targetDeleteId != null) {
            $data = GensenFormAttachmentRepository::delete(Crypt::decrypt($this->targetDeleteId));
        }
        Alert::success($this, 'Berhasil', 'Data berhasil dihapus');
        $this->getData();
    }

    public function clickFile($id, $url, $type)
    {
        $this->editedData = [
            'id' => $id,
            'type' => $type,
            'src' => $url,
        ];
        $this->dispatch('handleCropper', ['url' => $url]);
    }

    public function showFile($id, $url, $type, $file_name, $created_at, $isImage = false)
    {
        $this->showData = [
            'id' => $id,
            'file_name' => $file_name,
            'created_at' => $created_at,
            'type' => $type,
            'url' => $url,
            'isImage' => $isImage,
        ];
    }

    protected function attachmentInputs(): array
    {
        return [
            [
                'type' => GensenAttachmentType::KERTAS_GENSEN,
                'file' => $this->kertas_gensen,
                'action' => 'create'
            ],
            [
                'type' => GensenAttachmentType::MY_NUMBER_FRONT,
                'file' => $this->my_number_front,
                'action' => 'update'
            ],
            [
                'type' => GensenAttachmentType::MY_NUMBER_BACK,
                'file' => $this->my_number_back,
                'action' => 'update'
            ],
            [
                'type' => GensenAttachmentType::ZAIRYOU_CARD_FRONT,
                'file' => $this->zairyou_card_front,
                'action' => 'update'
            ],
            [
                'type' => GensenAttachmentType::ZAIRYOU_CARD_BACK,
                'file' => $this->zairyou_card_back,
                'action' => 'update'
            ],
            [
                'type' => GensenAttachmentType::KARTU_KELUARGA,
                'file' => $this->kartu_keluarga,
                'action' => 'create'
            ],
            [
                'type' => GensenAttachmentType::REKAP_PENGIRIMAN_UANG,
                'file' => $this->rekap_pengiriman_uang,
                'action' => 'create'
            ],
            [
                'type' => GensenAttachmentType::REKENING_INDONESIA,
                'file' => $this->rekening_indonesia,
                'action' => 'update'
            ],
        ];
    }

    public function store()
    {
        $this->validate();
        try {
            DB::transaction(function () {
                $gensenForm = GensenFormRepository::find(Crypt::decrypt($this->objId));
                $this->handleGensenFormAttachemntStore(
                    $this->photo,
                    $this->editedData['type'] ? GensenAttachmentType::fromLabel($this->editedData['type']) : null,
                    $gensenForm->id,
                    null,
                    'update',
                    Crypt::decrypt($this->editedData['id'])
                );
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
    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        $this->redirectRoute('gensen_data.attachment', [$this->objId]);
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        $this->redirectRoute('gensen_data.attachment', [$this->objId]);
    }

    public function submitChange()
    {
        $this->validate();
        try {
            DB::transaction(function () {
                $this->saveData(true);
                $gensenForm = GensenFormRepository::find(Crypt::decrypt($this->objId));
                $gensenForm->handleMergePersyaratanGensen();
                $gensenForm->handleMergeSeluruhBerkas();
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

    private function handleGensenFormAttachemntStore($file, $type, $gensenFormId, $path = null, $action = 'update', $attachment_id = null)
    {
        $storedName = Str::uuid() . '.' . $file->extension();

        $filePath = $path ? $path :  "gensen/{$gensenFormId}/{$type->value}";
        $path = $file->storeAs(
            $filePath,
            $storedName,
            'private'
        );


        $validatedData =  [
            'type' => $type,
            'disk' => 'private',
            'path' => $path,

            'stored_name' => $storedName,
            'status' => GensenAttachmenStatus::STATUS_EDITED,

            'extension' => $file->extension(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),

            'checksum' => hash_file('sha256', $file->getRealPath()),

            'uploaded_by' => auth()->id(),
        ];
        if ($attachment_id) {
            GensenFormAttachmentRepository::update($attachment_id, $validatedData);
        } elseif ($action == 'update') {
            $validatedData['original_name'] = $file->getClientOriginalName();

            $try = GensenFormAttachment::updateOrCreate([
                'gensen_form_id' => $gensenFormId,
                'type' => $type->value,
            ], $validatedData);

            $this->dispatch('consoleLog', [
                $try,
                $validatedData,
                [
                    ['gensen_form_id', $gensenFormId],
                    ['type', $type->value],
                ]
            ]);
        } else {
            GensenFormAttachmentRepository::create($validatedData);
        }
    }

    public function cobaStore() {}

    public function addRekapPengirimanUang()
    {
        $this->rekap_pengiriman_uang[] = [
            'file' => [],
            'remittance_type' => GensenAttachmentRemittanceType::REMITTANCE_NOT_REKAP_PENGIRIMAN->value
        ];
        $this->dispatch('initializeFileInputs');
    }

    public function saveData($withAttachment = false, $isSubmitted = null)
    {
        try {
            DB::transaction(function () use ($isSubmitted, $withAttachment) {
                $gensenForm = GensenFormRepository::find(Crypt::decrypt($this->objId));
                if ($withAttachment) {
                    $this->storeAttachments($gensenForm);
                }
                $gensenForm->onSubmitted();
                return true;
            });

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }
    public function submitImport()
    {
        $this->saveData(true, true);
        Alert::confirmation(
            $this,
            Alert::ICON_SUCCESS,
            "Berhasil",
            "Data Berhasil Disimpan",
            "on-dialog-confirm",
            "on-dialog-cancel",
            "Oke",
            "Tutup",
        );
    }
    protected function storeAttachments(GensenForm $gensenForm): void
    {
        DB::transaction(function () use ($gensenForm) {

            foreach ($this->attachmentInputs() as $input) {

                $type = $input['type'];
                $files = $input['file'];
                $action = $input['action'];


                if (!$files) {
                    continue;
                }

                // normalize jadi array
                $files = is_array($files) ? $files : [$files];

                foreach ($files as $file) {
                    if ($type === GensenAttachmentType::REKAP_PENGIRIMAN_UANG) {
                        foreach ($file['file'] as $item) {
                            $filePath = "gensen/{$gensenForm->id}/{$type->value}/" . $file['remittance_type'];
                            $this->handleGensenFormAttachemntImport($item, $type, $gensenForm, $filePath, $file['remittance_type'], $action);
                        }
                    } else {
                        $this->handleGensenFormAttachemntImport($file, $type, $gensenForm, null, null, $action);
                    }
                }
            }
        });
    }

    private function handleGensenFormAttachemntImport($file, $type, $gensenForm, $path = null, $remittance_type = GensenAttachmentRemittanceType::REMITTANCE_NOT_REKAP_PENGIRIMAN, $action = 'update')
    {
        $storedName = Str::uuid() . '.' . $file->extension();

        $filePath = $path ? $path :  "gensen/{$gensenForm->id}/{$type->value}";
        $path = $file->storeAs(
            $filePath,
            $storedName,
            'private'
        );
        $validatedData = [
            'gensen_form_id' => $gensenForm->id,

            'type' => $type,
            'disk' => 'private',
            'path' => $path,
            'remittance_type' => $remittance_type,

            'original_name' => $file->getClientOriginalName(),
            'stored_name' => $storedName,

            'extension' => $file->extension(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),

            'checksum' => hash_file('sha256', $file->getRealPath()),
        ];

        if ($action == 'update') {

            $try = GensenFormAttachment::updateOrCreate([
                'gensen_form_id' => $gensenForm->id,
                'type' => $type->value,
            ], $validatedData);

            $this->dispatch('consoleLog', [
                $try,
                $validatedData,
                [
                    ['gensen_form_id', $gensenForm->id],
                    ['type', $type->value],
                ]
            ]);
        } else {
            GensenFormAttachmentRepository::create($validatedData);
        }
    }

    public function render()
    {
        return view('livewire.gensen-form.gensen-data.attachment');
    }
}
