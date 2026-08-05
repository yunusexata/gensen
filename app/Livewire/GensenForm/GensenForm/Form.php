<?php

namespace App\Livewire\GensenForm\GensenForm;

use App\Enums\Gensen\EmailLogStatus;
use App\Enums\Gensen\GensenAttachmentRemittanceType;
use App\Enums\Gensen\GensenAttachmentType;
use App\Helpers\Alert;
use App\Helpers\AppCrypt;
use App\Mail\Admin\ClientAttachmentUploaded;
use App\Mail\Admin\ClientNewSubmission;
use App\Mail\GensenFormStatusLengkapMail;
use App\Models\Exata\Exata;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormAttachment;
use App\Models\GensenForm\GensenFormDetail;
use App\Models\GensenForm\GensenFormLink;
use App\Models\User;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use App\Repositories\GensenForm\GensenFormDetailRepository;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use App\Repositories\Service\SendEmailLogRepository;
use Exception;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;
    public $objId;
    public $gensenFormId = null;

    public $isAdmin = false;
    public $isCopyGensen = false;
    public $isUploadAttachment = false;
    public $isFirstCheck = false;
    public $targetDeleteId; // ATTACHMENT DELETE ID
    public $targetPropertyId; // ATTACHMENT DELETE ID

    #[Validate('required', message: 'Nama Harus Diisi', onUpdate: false)]
    public $nama_lengkap;
    #[Validate('required', message: 'Tanggal Lahir Harus Diisi', onUpdate: false)]
    public $tanggal_lahir;
    #[Validate('required', message: 'Email Harus Diisi', onUpdate: false)]
    public $email;

    #[Validate('required', message: 'Tanggal Kepulangan Harus Diisi', onUpdate: false)]
    public $tanggal_kepulangan;
    #[Validate('required', message: 'Nama Instagram Harus Diisi', onUpdate: false)]
    public $nama_instagram;
    #[Validate('required', message: 'Nama Tiktok Harus Diisi', onUpdate: false)]
    public $nama_tiktok;
    #[Validate('required', message: 'Nomor Whatsapp Harus Diisi', onUpdate: false)]
    public $nomor_whatsapp;
    #[Validate('required', message: 'Nomor Whatsapp Darurat Harus Diisi', onUpdate: false)]
    public $nomor_whatsapp_darurat;
    #[Validate('required', message: 'Alamat Jepang Harus Diisi', onUpdate: false)]
    public $alamat_jepang;
    #[Validate('required', message: 'Kode POS Harus Diisi', onUpdate: false)]
    public $kode_pos_jepang;
    // #[Validate('required', message: 'Nama LPK/SO/PT Harus Diisi', onUpdate: false)]
    public $nama_lpk;

    // REK PENERIMA
    #[Validate('required', message: 'No Rek Penerima Harus Diisi', onUpdate: false)]
    public $no_rekening_penerima;
    #[Validate('required', message: 'Nama Bank Penerima Harus Diisi', onUpdate: false)]
    public $nama_bank_penerima;
    #[Validate('required', message: 'Nama Penerima Harus Diisi', onUpdate: false)]
    public $nama_penerima;
    public $hubungan_penerima;

    public $status;
    // #[Validate('required', message: 'Tahun Gensen Harus Diisi', onUpdate: false)]
    // public $tahun_gensen;
    // public $tahun_transfer;
    #[Validate('required', message: 'Urus sendiri/konsultan lain Harus Diisi', onUpdate: false)]
    public $is_previously_processed;

    public $gensen_form_details = [];
    public $tahun_gensen_choice = [];
    public $is_should_filled = false;
    public $is_submitted = false;

    // Multiple Upload
    public $kertas_gensen = [];
    public $kartu_keluarga = [];
    public $rekap_pengiriman_uang = [];

    // Single Upload
    public $my_number_front;
    public $my_number_back;
    public $zairyou_card_front;
    public $zairyou_card_back;
    public $rekening_indonesia;

    public $kertas_gensen_note = [];
    public $rekap_pengiriman_uang_note = [];
    public $kartu_keluarga_note = [];
    public $my_number_front_note;
    public $my_number_back_note;
    public $zairyou_card_front_note;
    public $zairyou_card_back_note;
    public $rekening_indonesia_note;

    public $kertas_gensen_old = [];
    public $my_number_front_old = [];
    public $my_number_back_old = [];
    public $zairyou_card_front_old = [];
    public $zairyou_card_back_old = [];
    public $kartu_keluarga_old = [];
    public $rekap_pengiriman_uang_old = [];
    public $rekening_indonesia_old = [];

    public $kertas_gensen_old_note = [];
    public $my_number_front_old_note = [];
    public $my_number_back_old_note = [];
    public $zairyou_card_front_old_note = [];
    public $zairyou_card_back_old_note = [];
    public $kartu_keluarga_old_note = [];
    public $rekap_pengiriman_uang_old_note = [];
    public $rekening_indonesia_old_note = [];

    // public $cv = [];
    // public $cv_old = [];
    // public $cv_removes = [];

    public $input_password;
    public $max_attempts = 3;
    public $authorized = false;

    // Gensen Form Credential
    public $password;
    public $expired_at;

    public $pic_phone;

    public int $currentStep = 1;

    protected $listeners = [
        'stepper-next-request' => 'validateCurrentStep',
        'stepper-click-request' => 'handleStepClick',
    ];

    protected $rules = [
        'is_previously_processed' => ['in:sudah,belum'],
        // 'gensen_form_details.*.tahun_gensen' => ['required', 'integer'],
    ];

    protected $messages = [
        // 'is_previously_processed.required' => 'Urus sendiri/konsultan lain Harus Diisi',
        'is_previously_processed.in' => 'Urus sendiri/konsultan lain Harus Diisi',

        // 'gensen_form_details.required' => 'Detail Gensen wajib diisi.',
        // 'gensen_form_details.*.tahun_gensen.required' => 'Tahun gensen wajib diisi.',
        // 'gensen_form_details.*.tahun_gensen.integer' => 'Tahun gensen harus angka.',
    ];

    public function mount()
    {
        $this->tahun_gensen_choice =  collect(range(now()->year, now()->year - 5))
            ->map(function ($year) {
                return [
                    'value' => toReiwaYear($year),
                    'label' => toReiwaYear($year) . " / " . $year,
                ];
            })->values();
        if ($this->isUploadAttachment) {
            $id = simple_decrypt($this->gensenFormId);
            if (!$id) {
                abort(404, 'Link tidak valid atau telah dimanipulasi.');
            }
            $this->gensenFormId = $id;
            $this->authorized = true;
            $this->dispatch('onAuthorized');
            consoleLog($this, 'upload att');
            $this->validatationStepper(1);
        } else {
            $this->gensen_form_details[] = [
                'id' => null,
                'key' => Str::random(10),
                'tahun_gensen' => null,
                'nominal_gensen' => null,
            ];
            if ($this->isAdmin) {
                $this->authorized = true;
                $this->dispatch('onAuthorized');
            } else {
                $token = $this->objId;
                $this->checkForm($token);
            }
        }
    }
    private function checkForm($token)
    {
        try {
            if (!$token) {
                abort(404, 'Form Tidak Tersedia');
            }
            if (!Str::isUuid($token)) {
                abort(404);
            }
            $form = GensenFormLinkRepository::findBy([
                ['token', $token],
            ]);
            if (!$form) {
                abort(403, 'Form Tidak Tersedia');
            }
            if ($form->expired_at && now()->greaterThan($form->expired_at)) {
                GensenFormLinkRepository::updateBy(
                    [
                        ['token', $token]
                    ],
                    ['status' => GensenFormLink::STATUS_EXPIRED]
                );
                abort(403, "Form {$form['name']} sudah expired");
            }
            $this->password = $form->password;
        } catch (DecryptException $e) {
            abort(404, 'Form tidak tersedia');
        }
    }

    public function addGensenFormDetail()
    {
        $this->gensen_form_details[] = [
            'id' => null,
            'key' => Str::random(10),
            'tahun_gensen' => null,
            'nominal_gensen' => null,
        ];
    }

    public function deleteGensenFormDetail($index)
    {
        unset($this->gensen_form_details[$index]);

        // reindex array biar rapi (penting untuk Livewire)
        $this->gensen_form_details = array_values($this->gensen_form_details);
    }

    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        if ($this->isAdmin) {
            return redirect()->route('gensen_data.index');
        }

        if ($this->isUploadAttachment) {

            return redirect()->route(
                'gensen_form.success_default',
                ['phone' => $this->pic_phone]
            );
        }

        return redirect()->route('gensen_form.success', $this->objId);
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        if ($this->isAdmin) {
            return redirect()->route('gensen_data.index');
        }

        if ($this->isUploadAttachment) {

            return redirect()->route(
                'gensen_form.success_default',
                ['phone' => $this->pic_phone]
            );
        }
        return redirect()->route('gensen_form.success', $this->objId);
    }
    public function validateCurrentStep()
    {
        // consoleLog($this, [
        //     'current',
        //     $this->currentStep
        // ]);

        $this->validatationStepper($this->currentStep);


        $this->currentStep++;

        $this->dispatch('stepper-go-to', $this->currentStep);
    }
    private function validatationStepper($index)
    {
        consoleLog($this, $this->isUploadAttachment);
        consoleLog($this, ['index', $index]);
        if ($this->isUploadAttachment) {
            match ($index) {

                1 => (function () {
                    $this->validateStepPersonal();
                })(),
                2 => $this->validateStepReview(),
            };
        } else {
            match ($index) {

                1 => $this->validateStepPersonal(),

                2 => $this->validateStepReview(),
            };
        }
    }
    private function validateStepPersonal()
    {
        consoleLog($this, [
            'firstcheck',
            $this->isFirstCheck
        ]);
        // try {
        if (!$this->isFirstCheck) {
            $this->firstCheck(); // your existing logic
        } else {
            if (!$this->isUploadAttachment) {
                $this->validate();
            }

            $this->saveData(false);
        }
        // } catch (\Illuminate\Validation\ValidationException $e) {

        //     Alert::fail($this, "Gagal", $e->getMessage());
        //     return;
        // }
    }

    private function validateStepAttachment()
    {
        // if (!$this->isAttachmentReadyMerged()) {
        //     throw \Illuminate\Validation\ValidationException::withMessages([
        //         'attachment' => 'Attachment belum lengkap'
        //     ]);
        // }
    }
    private function validateStepReview()
    {
        // final validation
    }
    public function handleStepClick($step)
    {
        $target = $step;
        consoleLog($this, $target);
        consoleLog($this, $this->currentStep);

        $this->validatationStepper(1);
        $this->currentStep = $target;

        $this->dispatch('stepper-go-to', $target);
    }
    public function validatePersonalInformation($stepType)
    {
        // consoleLog($this, 'valid');
        // $this->validate();
        // $this->saveData(false);
        // consoleLog($this, [
        //     'index',
        //     $index
        // ]);
        $this->dispatch($stepType);
    }
    public function submitForm()
    {
        consoleLog($this, 'submit dong');
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

        // session()->flash('success', 'Form submitted!');
    }
    public function firstCheck()
    {
        consoleLog($this, ['first', $this->gensenFormId]);

        if ($this->gensenFormId) {
            $gensenForm = GensenFormRepository::find($this->gensenFormId);

            $this->nama_lengkap = $gensenForm->nama_lengkap;
            $this->email = $gensenForm->email;
            $this->tanggal_lahir = $gensenForm->tanggal_lahir;
        } else {

            $this->validate([
                'nama_lengkap' => 'required',
                'email' => 'required|email',
                'tanggal_lahir' => 'required',
            ]);
            $gensenForm = GensenForm::where([
                'nama_lengkap' => trim(Str::upper($this->nama_lengkap)),
                'email' => trim(Str::upper($this->email)),
                'tanggal_lahir' => trim($this->tanggal_lahir),
            ])
                ->where('status', '!=', GensenForm::STATUS_GENSEN_CAIR)
                ->first();
        }
        consoleLog($this, ['gensen_form firstcheck', $gensenForm]);
        if ($gensenForm) {

            if ($gensenForm->status !== GensenForm::STATUS_BELUM_LENGKAP) {
                return redirect()->route(
                    'gensen_form.success_default',
                    ['phone' => $gensenForm->getPicAttribute()->phone],
                );
            }
            $this->gensenFormId = $gensenForm->id;

            $this->tanggal_kepulangan = $gensenForm->tanggal_kepulangan;
            $this->nama_instagram = $gensenForm->nama_instagram;
            $this->nama_tiktok = $gensenForm->nama_tiktok;
            $this->nomor_whatsapp = $gensenForm->nomor_whatsapp;
            $this->nomor_whatsapp_darurat = $gensenForm->nomor_whatsapp_darurat;
            $this->email = $gensenForm->email;
            $this->alamat_jepang = $gensenForm->alamat_jepang;
            $this->kode_pos_jepang = $gensenForm->kode_pos_jepang;
            $this->nama_lpk = $gensenForm->nama_lpk;

            // REK PENERIMA
            $this->no_rekening_penerima = $gensenForm->no_rekening_penerima;
            $this->nama_bank_penerima = $gensenForm->nama_bank_penerima;
            $this->nama_penerima = $gensenForm->nama_penerima;
            $this->hubungan_penerima = $gensenForm->hubungan_penerima;

            $this->status = $gensenForm->status;
            // $this->tahun_gensen = $gensenForm->tahun_gensen;
            // $this->tahun_transfer = $gensenForm->tahun_transfer;

            $this->is_previously_processed = $gensenForm->is_previously_processed ? 'sudah' : 'belum';
            $this->is_should_filled = $gensenForm->is_should_filled;
            $this->is_submitted = $gensenForm->is_submitted;
            // Lampiran
            $this->isFirstCheck = true;
            if (!$this->is_should_filled) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'input_filled' => 'Data belum lengkap'
                ]);
            }

            $attachments = $gensenForm->attachmentGroups();
            consoleLog($this, $attachments);
            $this->kertas_gensen_old = $attachments[GensenAttachmentType::KERTAS_GENSEN->value] ?? [];
            $this->kartu_keluarga_old = $attachments[GensenAttachmentType::KARTU_KELUARGA->value] ?? [];
            $this->rekap_pengiriman_uang_old = $attachments[GensenAttachmentType::REKAP_PENGIRIMAN_UANG->value] ?? [];
            $this->my_number_front_old = $attachments[GensenAttachmentType::MY_NUMBER_FRONT->value] ?? [];
            $this->my_number_back_old = $attachments[GensenAttachmentType::MY_NUMBER_BACK->value] ?? [];
            $this->zairyou_card_front_old = $attachments[GensenAttachmentType::ZAIRYOU_CARD_FRONT->value] ?? [];
            $this->zairyou_card_back_old = $attachments[GensenAttachmentType::ZAIRYOU_CARD_BACK->value] ?? [];
            $this->rekening_indonesia_old = $attachments[GensenAttachmentType::REKENING_INDONESIA->value] ?? [];
        } else {
            if ($this->isAdmin) {
                consoleLog($this, 'buat baru');
                $this->saveData(false);
                if (!$this->is_should_filled) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'input_filled' => 'Data belum lengkap'
                    ]);
                }
            } else {
                if (!Str::isUuid($this->objId)) {
                    abort(404);
                }
                $form = GensenFormLinkRepository::findBy([
                    ['token', $this->objId],
                ]);
                if ($form->max_usage <= $form->used_count && $form->status == GensenFormLink::STATUS_SUCCESS) {
                    // abort(403, "Form {$form['name']} sudah Maksimal");

                    return redirect()
                        ->route('form.max-usage')
                        ->with('error', "Form {$form['name']} sudah maksimal");
                } else {
                    consoleLog($this, 'buat baru');
                    $this->saveData(false);
                    if (!$this->is_should_filled) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'input_filled' => 'Data belum lengkap'
                        ]);
                    }
                }
            }
        }
    }

    public function checkPassword()
    {
        try {
            // $token = $this->objId;
            // $this->checkForm($token);

            // ✅ password validation
            if ($this->input_password !== $this->password) {

                $this->max_attempts--;

                Alert::fail(
                    $this,
                    "Password Salah",
                    "Sisa percobaan: {$this->max_attempts}"
                );

                // lock form when attempts finished
                if ($this->max_attempts <= 0) {

                    abort(404, 'Form tidak tersedia');
                }

                return;
            }

            // ✅ SUCCESS ACCESS
            $this->authorized = true;

            Alert::success($this, "Berhasil", "Password benar");
            $this->dispatch('onAuthorized');
        } catch (DecryptException $e) {
            abort(404, 'Form tidak tersedia');
        }
    }

    public function addRekapPengirimanUang()
    {
        $this->rekap_pengiriman_uang[] = [
            'file' => [],
            'remittance_type' => GensenAttachmentRemittanceType::REMITTANCE_NOT_REKAP_PENGIRIMAN->value
        ];
        $this->dispatch('initializeFileInputs');
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

    public function showDialogDeleteFile($id, $property)
    {
        $this->targetDeleteId = $id;
        $this->targetPropertyId = $property;
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
        $this->targetPropertyId = null;
    }
    #[On('on-delete-dialog-file-confirm')]
    public function onDialogDeleteFileConfirm()
    {
        $id = AppCrypt::decrypt($this->targetDeleteId);
        if (!$id) {
            abort(404, 'Link tidak valid atau telah dimanipulasi.');
        }

        $data = GensenFormAttachmentRepository::delete($id);
        Alert::success($this, 'Berhasil', 'Data berhasil dihapus');
        $this->removeAttachmentFromGroups($this->targetDeleteId, $this->targetPropertyId);

        $this->targetDeleteId = null;
        $this->targetPropertyId = null;
        $this->dispatch('onAuthorized');
    }
    private function removeAttachmentFromGroups($attachmentId, $property)
    {

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

    public function saveData($withAttachment = false, $isSubmitted = null)
    {
        try {

            DB::transaction(function () use ($isSubmitted, $withAttachment) {
                // $nomor_whatsapp = preg_replace('/[^\d]/', '', $this->nomor_whatsapp);
                // $nomor_whatsapp_darurat = preg_replace('/[^\d]/', '', $this->nomor_whatsapp_darurat);
                // Form Candidate
                $validateData = [
                    // Form J-Expert
                    'nama_lengkap' => trim($this->nama_lengkap),
                    'tanggal_lahir' => $this->tanggal_lahir,
                    'tanggal_kepulangan' => $this->tanggal_kepulangan,
                    'nama_instagram' => trim($this->nama_instagram),
                    'nama_tiktok' => trim($this->nama_tiktok),
                    'nomor_whatsapp' => trim($this->nomor_whatsapp),
                    'nomor_whatsapp_darurat' => trim($this->nomor_whatsapp_darurat),
                    'email' => trim($this->email),
                    'alamat_jepang' => trim($this->alamat_jepang),
                    // 'kode_pos_jepang' => trim($this->kode_pos_jepang),
                    'kode_pos_jepang' => trim(str_replace('-', '', $this->kode_pos_jepang)),
                    'nama_lpk' => trim($this->nama_lpk),

                    // REK PENERIMA
                    'no_rekening_penerima' => trim($this->no_rekening_penerima),
                    'nama_bank_penerima' => trim($this->nama_bank_penerima),
                    'nama_penerima' => trim($this->nama_penerima),
                    'hubungan_penerima' => trim($this->hubungan_penerima),

                    'is_previously_processed' => $this->is_previously_processed === 'sudah',

                    // 'tahun_gensen' => $this->tahun_gensen,
                    // 'tahun_transfer' => $this->tahun_transfer,

                ];
                if ($this->gensenFormId) {
                    if (!is_null($isSubmitted)) {
                        $validateData = array_merge($validateData, [
                            'is_submitted' => $isSubmitted,
                        ]);
                    }
                    consoleLog($this, $validateData);
                    GensenFormRepository::update($this->gensenFormId, $validateData);
                } else {
                    $remarks = Auth::check()
                        ? Auth::user()
                        : GensenFormLinkRepository::findBy([
                            ['token', $this->objId]
                        ]);

                    $validateData = array_merge($validateData, [
                        'remarks_id' => $remarks->id,
                        'remarks_type' => Auth::check()
                            ? User::class
                            : GensenFormLink::class,
                        'pic_code' => $remarks->pic_code,
                        'is_submitted' => $isSubmitted ? $isSubmitted : false,
                    ]);
                    $gensenForm = GensenFormRepository::create($validateData);
                    $this->gensenFormId = $gensenForm->id;
                }
                foreach ($this->gensen_form_details as $gensen_form_detail) {
                    if ($gensen_form_detail['id']) {

                        if ($gensen_form_detail['tahun_gensen']) {
                            GensenFormDetailRepository::update($gensen_form_detail['id'], [
                                'gensen_form_id' => $this->gensenFormId,
                                'tahun_gensen' => $gensen_form_detail['tahun_gensen'],
                            ]);
                        }
                    } else {

                        if ($gensen_form_detail['tahun_gensen']) {
                            GensenFormDetail::updateOrCreate([
                                'gensen_form_id' => $this->gensenFormId,
                                'tahun_gensen' => $gensen_form_detail['tahun_gensen'],
                            ], [
                                'gensen_form_id' => $this->gensenFormId,
                                'tahun_gensen' => $gensen_form_detail['tahun_gensen'],
                            ]);
                        }
                    }
                }
                consoleLog($this, $this->gensenFormId);
                $gensenForm = GensenFormRepository::find($this->gensenFormId);
                $this->is_should_filled = $gensenForm->is_should_filled;
                $this->is_submitted = $gensenForm->is_submitted;

                $this->pic_phone = $gensenForm->getPicAttribute()->no_whatsapp;

                consoleLog($this, ['gensenForm nih', $gensenForm]);
                consoleLog($this, $withAttachment ? 'YA ATT' : 'TIDAK ATT');

                if ($withAttachment) {

                    $batchId = Str::uuid();
                    $this->storeAttachments($gensenForm, $batchId);

                    if ($this->isUploadAttachment && !$this->isAdmin) {
                        SendEmailLogRepository::create(
                            [
                                'subject_type' => GensenForm::class,
                                'subject_id' => $gensenForm->id,
                                'data' => json_encode([
                                    'upload_batch_id' => $batchId
                                ], true),
                                'email' => $gensenForm->getPicAttribute()->email,
                                'mailable' => ClientAttachmentUploaded::class,
                                'subject_line' => "[{$gensenForm->getPicAttribute()->name}] Dokumen Baru Diunggah: {$gensenForm->nama_lengkap}",
                                'status' => EmailLogStatus::PENDING,
                                'queued_at' => now(),
                            ]
                        );
                    } elseif (!$this->isUploadAttachment && !$this->isAdmin) {
                        SendEmailLogRepository::create(
                            [
                                'subject_type' => GensenForm::class,
                                'subject_id' => $gensenForm->id,
                                'email' => $gensenForm->getPicAttribute()->email,
                                'mailable' => ClientNewSubmission::class,
                                'subject_line' => "[{$gensenForm->getPicAttribute()->name}] Notifikasi Form Submission Sukses: {$gensenForm->nama_lengkap}",
                                'status' => EmailLogStatus::PENDING,
                                'queued_at' => now(),
                            ]
                        );
                    }
                }
                $gensenForm->onSubmitted();
                $this->isFirstCheck = true;
            });

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        } catch (ValidationException $e) {
            DB::rollBack();

            consoleLog($this, ['validation', $e->errors()]);

            $message = collect($e->errors())
                ->flatten()
                ->first();

            Alert::fail($this, "Gagal", $message);

            return;
        }
    }

    protected function attachmentRules(): array
    {
        return [
            // Multiple Upload
            'kertas_gensen.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'kartu_keluarga.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'rekap_pengiriman_uang.file.*' => 'nullable|file|mimes:pdf|max:10240',

            // Single Upload
            'my_number_front' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            'my_number_back' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            'zairyou_card_front' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            'zairyou_card_back' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            'rekening_indonesia' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
        ];
    }

    protected function storeAttachments(GensenForm $gensenForm, $batchId = null): void
    {
        try {
            $this->validate($this->attachmentRules());
        } catch (ValidationException $e) {
            Alert::fail(
                $this,
                'Validasi Gagal',
                $e->validator->errors()->first()
            );
            return;
        }
        DB::transaction(function () use ($gensenForm, $batchId) {
            consoleLog($this, $gensenForm);
            consoleLog($this, 'store attachment');
            consoleLog($this, $this->attachmentInputs());

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
                    consoleLog($this, $file);
                    if ($type === GensenAttachmentType::REKAP_PENGIRIMAN_UANG) {
                        foreach ($file['file'] as $item) {
                            $filePath = "gensen/{$gensenForm->id}/{$type->value}/" . $file['remittance_type'];
                            $this->handleGensenFormAttachmentStore($item, $type, $gensenForm, $filePath, $file['remittance_type'], $action, $batchId);
                        }
                    } else {
                        $this->handleGensenFormAttachmentStore($file, $type, $gensenForm, null, null, $action, $batchId);
                    }
                }
            }
        });
    }

    private function handleGensenFormAttachmentStore($file, $type, $gensenForm, $path = null, $remittance_type = GensenAttachmentRemittanceType::REMITTANCE_NOT_REKAP_PENGIRIMAN, $action = 'update', $batchId = null)
    {
        $storedName = Str::uuid() . '.' . $file->extension();

        $filePath = $path ? $path :  "gensen/{$gensenForm->id}/{$type->value}";
        // $path = $file->storeAs(
        //     $filePath,
        //     $storedName,
        //     'private'
        // );

        $disk = env('DEFAULT_STORE_DISK', 'private');
        $path = Storage::disk($disk)->putFileAs(
            $filePath,
            $file,
            $storedName,
            [
                'visibility' => 'private',
            ]
        );

        $validatedData = [
            'gensen_form_id' => $gensenForm->id,
            'upload_batch_id' => $batchId,

            'type' => $type,
            'disk' => $disk,
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

    public function cobaStore()
    {
        // foreach ($this->photo as $item) {
        //     consoleLog(
        //         $this,
        //         [
        //             'compress',
        //             $item->getClientOriginalName(),
        //             $item->getSize(),
        //             $item->temporaryUrl(),
        //         ]
        //     );
        // }
        foreach ($this->kertas_gensen as $item) {
            consoleLog(
                $this,
                [
                    'original',
                    $item->getClientOriginalName(),
                    $item->getSize(),
                    $item->temporaryUrl(),
                ]
            );
        }
    }

    public function render()
    {
        return view('livewire.gensen-form.gensen-form.form');
    }
}
