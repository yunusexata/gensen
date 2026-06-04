<?php

namespace App\Livewire\IchijikinExtraction;

use App\Helpers\Alert;
use App\Helpers\ExportHelper;
use App\Jobs\IchijikinExtraction\DrawLabelIchijikinJob;
use App\Models\Ai\AiJob;
use App\Models\Exata\ExataFormCandidate;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormLink;
use App\Models\Ichijikin\IchijikinExtraction;
use App\Models\Ichijikin\IchijikinExtractionResult;
use App\Repositories\Exata\ExataFormCandidateRepository;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionFileRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionResultRepository;
use App\Repositories\MasterData\Regency\RegencyRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $objId;

    public $file_ichijikin;
    public $ichijikin_file;
    public $nama_lengkap;
    public $no_nenkin;
    public $lama_kerja;
    public $kokumin;
    public $nenkin_100;
    public $nenkin_80;
    public $nenkin_20;
    public $alamat;
    public $type;
    public $confidence_score;
    public $confidence_note;

    public $photo;

    public function mount()
    {
        if ($this->objId) {
            $this->ichijikin_file = IchijikinExtractionFileRepository::find(Crypt::decrypt($this->objId));
            $ichijikin_result = $this->ichijikin_file->result;
            dd([
                $this->ichijikin_file,
                $ichijikin_result
            ]);

            $this->nama_lengkap = $ichijikin_result->nama_lengkap;
            $this->no_nenkin = $ichijikin_result->no_nenkin;
            $this->lama_kerja = $ichijikin_result->lama_kerja;
            $this->kokumin = $ichijikin_result->kokumin;
            $this->nenkin_100 = $ichijikin_result->nenkin_100;
            $this->nenkin_80 = $ichijikin_result->nenkin_80;
            $this->nenkin_20 = $ichijikin_result->nenkin_20;
            $this->confidence_score = $ichijikin_result->confidence_score;
            $this->confidence_note = $ichijikin_result->confidence_note;
            $this->alamat = $ichijikin_result->alamat;
            $this->type = $ichijikin_result->type;
        }
    }

    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        if ($this->objId) {
            $this->redirectRoute('ichijikin_extraction.edit', $this->objId);
        } else {
            $this->redirectRoute('ichijikin_extraction.create');
        }
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        $this->redirectRoute('ichijikin_extraction.index');
    }



    public function store()
    {
        try {
            DB::transaction(function () {
                $validatedData = [
                    'nama_lengkap' => $this->nama_lengkap,
                    'no_nenkin' => $this->no_nenkin,
                    'lama_kerja' => $this->lama_kerja,
                    'kokumin' => $this->kokumin,
                    'nenkin_100' => $this->nenkin_100,
                    'nenkin_80' => $this->nenkin_80,
                    'nenkin_20' => $this->nenkin_20,
                    'confidence_score' => $this->confidence_score,
                    'confidence_note' => $this->confidence_note,
                    'alamat' => $this->alamat,
                    'type' => $this->type,
                ];
                IchijikinExtractionResultRepository::updateBy([
                    ['ichijikin_extraction_file_id', Crypt::decrypt($this->objId)]
                ], $validatedData);

                // $disk = env('DEFAULT_STORE_DISK', 'public');
                $directory = dirname($this->ichijikin_file->path);
                $path = Storage::disk('public')->putFileAs(
                    $directory,
                    $this->photo,
                    $this->ichijikin_file->file_stored_name,
                    [
                        'visibility' => 'private',
                    ]
                );

                IchijikinExtractionFileRepository::update(Crypt::decrypt($this->objId), [
                    'file_size' => $this->photo->getSize()
                ]);

                $job = AiJob::create([
                    'subject_type' => self::class,
                    'subject_id'   => Crypt::decrypt($this->objId),
                    'job_type'     => AiJob::JOB_TYPE_ICHIJIKIN_EXTRACTION,
                    'status'       => 'pending',
                    'provider'     => 'gemini-ai',
                    'model'        => env('GEMINI_MODEL', 'gemini-3.1-flash-lite'),
                ]);

                DrawLabelIchijikinJob::dispatch(IchijikinExtractionResultRepository::findBy([
                    ['ichijikin_extraction_file_id', Crypt::decrypt($this->objId)]
                ]))->onQueue('crop');
            });


            DB::commit();
            Alert::information($this, 'Data berhasil disimpan');
            // $this->getData();

            $this->dispatch('handleGetData');
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.ichijikin-extraction.edit');
    }
}
