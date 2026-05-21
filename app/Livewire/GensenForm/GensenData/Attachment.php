<?php

namespace App\Livewire\GensenForm\GensenData;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentRemittanceType;
use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Models\Ai\AiJob;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormAttachment;
use App\Models\User;
use App\Repositories\Ai\AiJobRepository;
use App\Repositories\Gensen\Ai\RemittanceExtractionGroupRepository;
use App\Repositories\Gensen\Ai\RemittanceExtractionRepository;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use App\Repositories\GensenForm\GensenFormDetailRepository;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use App\Repositories\GensenForm\PersyaratanGensenJobRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
    public $targetDeleteType;
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

    public $tahun_gensen_details = [];
    public $nominal_gensen;
    public $gensen_has_ai_jobs = false;
    public $gensen_has_pending_ai_jobs = false;
    public $remittance_extraction_confidence = 0;
    public $remittance_validate_total = 0;
    public $remittance_extraction_groups = [];
    public $onload = false;
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

    protected $listeners = [
        'remittance-extraction-updated' => 'getRemittanceExtraction',
        'merge-attachment-updated' => 'getMergeAttachment'
    ];

    public function mount()
    {
        $this->getData();
    }

    public function updatedRemittanceExtractionGroups($value, $index)
    {
        try {
            consoleLog($this, $value);
            $el = explode('.', $index);
            consoleLog($this, $el);
            if ($el[1] == 'is_validate') {
                if ($value) {
                    $this->remittance_validate_total += $this->remittance_extraction_groups[$el[0]]['total_amount'];
                } else {
                    $this->remittance_validate_total -= $this->remittance_extraction_groups[$el[0]]['total_amount'];
                }
            }
        } catch (Exception $e) {
            consoleLog($this, $e->getMessage());
        }
    }

    public function addGensenFormDetail()
    {
        $this->tahun_gensen_details[] = [
            'id' => null,
            'key' => Str::random(10),
            'tahun_gensen' => null,
            'nominal_gensen' => null,
        ];
    }

    public function confirmRemittanceValidation()
    {
        try {
            if (empty($this->tahun_gensen_details)) {
                throw new Exception("Data Gensen harus di isi!");
            }
            DB::transaction(function () {
                foreach ($this->remittance_extraction_groups as $remittance) {
                    if ($remittance['is_validate'] && !$remittance['receiver_relationship']) {
                        throw new Exception("Jika Valid, Hubungan harus di isi!");
                    }
                    RemittanceExtractionGroupRepository::update($remittance['id'], [
                        'is_validate' => $remittance['is_validate'],
                        'receiver_relationship' => $remittance['receiver_relationship'],
                    ]);
                }
                foreach ($this->tahun_gensen_details as $tahun_gensen) {
                    if ($tahun_gensen['id']) {
                        if (!$tahun_gensen['tahun_gensen'] && !$tahun_gensen['nominal_gensen']) {
                            GensenFormDetailRepository::delete($tahun_gensen['id']);
                        } else {
                            GensenFormDetailRepository::update($tahun_gensen['id'], [
                                'tahun_gensen' => $tahun_gensen['tahun_gensen'],
                                'nominal_gensen' => $tahun_gensen['nominal_gensen'],
                            ]);
                        }
                    } else {
                        if ($tahun_gensen['tahun_gensen'] && $tahun_gensen['nominal_gensen']) {
                            GensenFormDetailRepository::create([
                                'gensen_form_id' => Crypt::decrypt($this->objId),
                                'tahun_gensen' => $tahun_gensen['tahun_gensen'],
                                'nominal_gensen' => $tahun_gensen['nominal_gensen'],
                            ]);
                        }
                    }
                }
                $remittance_extraction = RemittanceExtractionRepository::findBy([
                    ['subject_id', Crypt::decrypt($this->objId)],
                    ['subject_type', GensenForm::class]
                ]);
                if ($remittance_extraction) {
                    $remittance_extraction->syncSubjectTotal();
                }
            });
            $this->getTahunGensenDetails();
            DB::commit();
            Alert::information($this, 'Data berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    public function submitRemittanceExtractionJob()
    {
        try {
            $this->confirmRemittanceValidation();
            DB::transaction(function () {
                $job = AiJob::firstOrCreate(
                    [
                        'subject_type' => GensenForm::class,
                        'subject_id'   => Crypt::decrypt($this->objId),
                        'job_type'     => AiJob::JOB_TYPE_REMITTANCE_EXTRACTION,
                        'status'       => 'pending',
                    ],
                    [
                        'provider' => 'gemini-ai',
                        'model'    => env('GEMINI_MODEL', 'gemini-3.1-flash-lite'),
                    ]
                );
                if ($job) {
                    $this->gensen_has_ai_jobs = true;
                    $this->gensen_has_pending_ai_jobs = true;
                }
            });

            DB::commit();
            Alert::information($this, 'Data berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    private function getTahunGensenDetails()
    {

        if ($this->objId) {
            $gensen = GensenFormRepository::find(Crypt::decrypt($this->objId));

            $this->tahun_gensen_details = $gensen->gensenFormDetails->toArray();
        }
    }

    private function getData()
    {
        if ($this->objId) {
            $gensen = GensenFormRepository::find(Crypt::decrypt($this->objId));
            $this->nama_lengkap = $gensen->nama_lengkap;
            $this->tanggal_lahir = $gensen->tanggal_lahir;
            $this->nomor_whatsapp = $gensen->nomor_whatsapp;
            $this->tahun_gensen_details = $gensen->gensenFormDetails->toArray();
            $this->nominal_gensen = $gensen->nominal_gensen;

            $attachments = $gensen->attachmentGroups([
                GensenAttachmentType::MY_NUMBER_FRONT,
                GensenAttachmentType::MY_NUMBER_BACK,
                GensenAttachmentType::ZAIRYOU_CARD_FRONT,
                GensenAttachmentType::ZAIRYOU_CARD_BACK,
                GensenAttachmentType::REKENING_INDONESIA,
            ]);
            // dd($this->remittance_extraction_groups);
            if ($this->kertas_gensen) {
                $this->kertas_gensen_old = $attachments[GensenAttachmentType::KERTAS_GENSEN->value];
                $this->kertas_gensen = null;
            }
            if ($this->my_number_front) {
                $this->my_number_front_old = $attachments[GensenAttachmentType::MY_NUMBER_FRONT->value];
                $this->my_number_front = null;
            }
            if ($this->my_number_back) {
                $this->my_number_back_old = $attachments[GensenAttachmentType::MY_NUMBER_BACK->value];
                $this->my_number_back = null;
            }
            if ($this->zairyou_card_front) {
                $this->zairyou_card_front_old = $attachments[GensenAttachmentType::ZAIRYOU_CARD_FRONT->value];
                $this->zairyou_card_front = null;
            }
            if ($this->zairyou_card_back) {
                $this->zairyou_card_back_old = $attachments[GensenAttachmentType::ZAIRYOU_CARD_BACK->value];
                $this->zairyou_card_back = null;
            }
            if ($this->kartu_keluarga) {
                $this->kartu_keluarga_old = $attachments[GensenAttachmentType::KARTU_KELUARGA->value];
                $this->kartu_keluarga = null;
            }
            if ($this->rekap_pengiriman_uang) {
                $this->rekap_pengiriman_uang_old = $attachments[GensenAttachmentType::REKAP_PENGIRIMAN_UANG->value];
                $this->rekap_pengiriman_uang = null;
            }
            if ($this->rekening_indonesia) {
                $this->rekening_indonesia_old = $attachments[GensenAttachmentType::REKENING_INDONESIA->value];
                $this->rekening_indonesia = null;
            }

            $this->my_number_front_old = $attachments[GensenAttachmentType::MY_NUMBER_FRONT->value];
            $this->my_number_back_old = $attachments[GensenAttachmentType::MY_NUMBER_BACK->value];
            $this->zairyou_card_front_old = $attachments[GensenAttachmentType::ZAIRYOU_CARD_FRONT->value];
            $this->zairyou_card_back_old = $attachments[GensenAttachmentType::ZAIRYOU_CARD_BACK->value];
            $this->rekening_indonesia_old = $attachments[GensenAttachmentType::REKENING_INDONESIA->value];

            $this->isCanDelete = $gensen->isCanDelete();
        }
    }
    public function getOnload()
    {
        consoleLog($this, 'onload');
        $gensen = GensenFormRepository::find(Crypt::decrypt($this->objId));
        $this->nama_lengkap = $gensen->nama_lengkap;
        $this->tanggal_lahir = $gensen->tanggal_lahir;
        $this->nomor_whatsapp = $gensen->nomor_whatsapp;

        $attachments = $gensen->attachmentGroups([
            GensenAttachmentType::KERTAS_GENSEN,
            GensenAttachmentType::KARTU_KELUARGA,
            GensenAttachmentType::REKAP_PENGIRIMAN_UANG,
            GensenAttachmentType::PERSYARATAN_PENGURUSAN_GENSEN,
            GensenAttachmentType::SELURUH_BERKAS,
        ]);
        $this->kertas_gensen_old = $attachments[GensenAttachmentType::KERTAS_GENSEN->value];
        $this->kartu_keluarga_old = $attachments[GensenAttachmentType::KARTU_KELUARGA->value];
        $this->rekap_pengiriman_uang_old = $attachments[GensenAttachmentType::REKAP_PENGIRIMAN_UANG->value];
        $this->persyaratan_pengurusan_gensen_old = $attachments[GensenAttachmentType::PERSYARATAN_PENGURUSAN_GENSEN->value];
        $this->seluruh_berkas_old = $attachments[GensenAttachmentType::SELURUH_BERKAS->value];

        $this->getRemittanceExtraction($gensen);
    }
    public function getRemittanceExtraction($gensen = null, $gensen_form_id = null)
    {

        if ($gensen_form_id && Crypt::decrypt($this->objId) != $gensen_form_id) {
            consoleLog($this, 'g sama');
            return;
        }
        consoleLog($this, 'sama id');

        if (!$gensen) {
            $gensen = GensenFormRepository::find(Crypt::decrypt($this->objId));
        }
        // dd($gensen->with('aiJobs')->first());
        // dd($gensen->aiJobs()->exists());

        $this->onload = true;
        if (!$gensen->aiJobs()->exists()) {
            consoleLog($this, 'step A');
            $this->gensen_has_ai_jobs = false;
            $this->gensen_has_pending_ai_jobs = false;
            return;
        }
        if ($gensen->aiJobs()->exists() && $gensen->hasPendingAiJob()) {
            consoleLog($this, 'step B');
            $this->gensen_has_ai_jobs = true;
            $this->gensen_has_pending_ai_jobs = true;
            return;
        }
        if (
            $gensen->remittanceExtraction()->exists()
        ) {
            consoleLog($this, 'step C');
            $this->gensen_has_ai_jobs = true;
            $this->gensen_has_pending_ai_jobs = false;
            $this->remittance_extraction_confidence = $gensen->remittanceExtraction->confidence_score;
            $this->remittance_validate_total = 0;
            consoleLog($this, [$gensen->remittanceExtraction
                ->remittanceExtractionGroups->toArray()]);
            $this->remittance_extraction_groups = $gensen->remittanceExtraction
                ? $gensen->remittanceExtraction
                ->remittanceExtractionGroups
                ->map(function ($group) {
                    $groupArray = $group->toArray();
                    if ($group->is_validate) {
                        $this->remittance_validate_total += $group->total_amount;
                    }
                    $groupArray['amount_details'] =
                        json_decode($group->amount_details, true) ?? [];

                    return $groupArray;
                })
                ->values()
                ->toArray()
                : [];
        }
        // if ($gensen->remittanceExtraction && $gensen->remittanceExtraction->aiJob()->status != JobStatus::PENDING) {

        // dd($this->remittance_extraction->remittanceExtractionGroups->toArray());

        // }
    }
    public function getMergeAttachment($gensen_form_id = null)
    {
        if (!$gensen_form_id && ($gensen_form_id && Crypt::decrypt($this->objId) != $gensen_form_id)) {
            return;
        }

        $gensen = GensenFormRepository::find(Crypt::decrypt($this->objId));

        $attachments = $gensen->attachmentGroups([
            GensenAttachmentType::PERSYARATAN_PENGURUSAN_GENSEN,
            GensenAttachmentType::SELURUH_BERKAS,
        ]);
        $this->persyaratan_pengurusan_gensen_old = $attachments[GensenAttachmentType::PERSYARATAN_PENGURUSAN_GENSEN->value];
        $this->seluruh_berkas_old = $attachments[GensenAttachmentType::SELURUH_BERKAS->value];
    }
    private function getDataGenerated()
    {

        if ($this->objId) {
            $gensen = GensenFormRepository::find(Crypt::decrypt($this->objId));

            $attachments = $gensen->attachmentGroups(
                [
                    GensenAttachmentType::PERSYARATAN_PENGURUSAN_GENSEN,
                    GensenAttachmentType::SELURUH_BERKAS,
                ]
            );
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

    public function showDialogDeleteFile($id, $type)
    {
        $this->targetDeleteId = $id;
        $this->targetDeleteType = $type . "_old";
        consoleLog($this, $this->targetDeleteType);
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
        $this->targetDeleteType = null;
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

        Alert::information($this, 'Data berhasil dihapus');
        $this->removeAttachmentFromGroups($this->targetDeleteId, $this->targetDeleteType);

        $this->targetDeleteId = null;
        $this->targetDeleteType = null;
        // $this->getData($this->targetDeleteType);
    }

    private function removeAttachmentFromGroups($attachmentId, $property)
    {

        $property = Str::lower($property);
        consoleLog($this, [
            'property',
            $property
        ]);
        if (isset($this->{$property})) {
            $data = $this->{$property};

            // CASE 1: grouped (has 'groups')
            if (isset($data['groups'])) {
                $data['groups'] = collect($data['groups'])
                    ->map(function ($group) use ($attachmentId) {
                        $group['files'] = collect($group['files'])
                            ->reject(fn($file) => $file['id'] === $attachmentId)
                            ->values()
                            ->toArray();

                        return $group;
                    })
                    ->filter(fn($group) => count($group['files']) > 0) // remove empty provider
                    ->values()
                    ->toArray();

                $data['uploaded'] = count($data['groups']) > 0;
                consoleLog($this, $data);
                consoleLog($this, $this->{$property});
                $this->{$property} = $data;
                return;
            }

            // CASE 2: single file
            if (isset($data['id']) && $data['id'] === $attachmentId) {
                consoleLog($this, 'GAK GROUPS');
                $this->{$property}['id'] = null;
                $this->{$property}['uploaded'] = false;
                $this->{$property}['url'] = null;
            }
        }
        consoleLog($this, $this->{$property});
    }

    public function clickFile($id, $name, $type)
    {
        $url = $this->{$name}['url'];
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
            $this->getData();
            Alert::information($this, 'Data berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }
    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        $this->getData();
        // $this->redirectRoute('gensen_data.attachment', [$this->objId]);
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        $this->getData();
        // $this->redirectRoute('gensen_data.attachment', [$this->objId]);
    }

    public function submitChange()
    {

        consoleLog($this, 'create save');
        try {
            DB::transaction(function () {
                $this->saveData(true);
                $gensenForm = GensenFormRepository::find(Crypt::decrypt($this->objId));
                $gensenForm->handleMergePersyaratanGensen();
            });

            DB::commit();
            $this->getData();
            Alert::information($this, 'Data berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    public function submitMergeJob()
    {
        try {
            DB::transaction(function () {
                $gensenForm = GensenFormRepository::find(Crypt::decrypt($this->objId));
                $gensenForm->handleMergePersyaratanGensen();
                $gensenForm->handleMergeSeluruhBerkas();
            });

            DB::commit();
            Alert::information($this, 'Data berhasil disimpan');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    private function handleGensenFormAttachemntStore($file, $type, $gensenFormId, $path = null, $action = 'update', $attachment_id = null)
    {
        $storedName = Str::uuid() . '.' . $file->extension();

        $filePath = $path ? $path :  "gensen/{$gensenFormId}/{$type->value}";
        // $path = $file->storeAs(
        //     $filePath,
        //     $storedName,
        //     'private'
        // );
        $path = Storage::disk('supabase')->putFileAs(
            $filePath,
            $file,
            $storedName,
            [
                'visibility' => 'private',
            ]
        );


        $validatedData =  [
            'type' => $type,
            'disk' => 'supabase',
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
        // $path = $file->storeAs(
        //     $filePath,
        //     $storedName,
        //     'private'
        // );
        $path = Storage::disk('supabase')->putFileAs(
            $filePath,
            $file,
            $storedName,
            [
                'visibility' => 'private',
            ]
        );
        $validatedData = [
            'gensen_form_id' => $gensenForm->id,

            'type' => $type,
            'disk' => 'supabase',
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
