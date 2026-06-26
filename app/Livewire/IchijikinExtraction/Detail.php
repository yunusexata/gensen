<?php

namespace App\Livewire\IchijikinExtraction;

use App\Helpers\Alert;
use App\Helpers\ExportHelper;
use App\Models\Exata\ExataFormCandidate;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormLink;
use App\Models\Ichijikin\IchijikinExtraction;
use App\Models\Ichijikin\IchijikinExtractionDetail;
use App\Repositories\Exata\ExataFormCandidateRepository;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionFileRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionRepository;
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

class Detail extends Component
{
    use WithFileUploads;

    public $objId;

    public $file_ichijikin;
    public $batch_name;

    public function mount()
    {
        if ($this->objId) {
            $this->batch_name = IchijikinExtractionRepository::find(Crypt::decrypt($this->objId))->batch_name;
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


    #[On('export')]
    public function export($type)
    {
        $fileName = "Data Ichijikin $this->batch_name " . Carbon::now()->format('Y-m-d H:i:s');
        return ExportHelper::export(
            $type,
            $fileName,
            IchijikinExtractionFileRepository::datatable(Crypt::decrypt($this->objId))->orderBy('file_stored_name', 'ASC'),
            'app.ichijikin-extraction.export',
            [
                'title' => "Data Ichijikin $this->batch_name",
                'type' => $type,
            ],
            [
                'size' => 'legal',
                'orientation' => 'landscape',
            ]
        );
    }


    public function store()
    {
        try {
            DB::transaction(function () {
                $disk = 'public';
                // Vehicle
                $validateData = [
                    'batch_name' => $this->batch_name,
                    'description' => null,
                ];

                if ($this->objId) {
                    $ichijin_id = Crypt::decrypt($this->objId);
                    IchijikinExtraction::update($ichijin_id, $validateData);
                } else {
                    $ichijikin = IchijikinExtraction::create($validateData);
                }
                foreach ($this->file_ichijikin as $file) {

                    $fileName = $file->getClientOriginalName();
                    $fileBaseName = \Illuminate\Support\Str::slug(
                        pathinfo(
                            $file->getClientOriginalName(),
                            PATHINFO_FILENAME
                        )
                    );
                    $filePath = $file->storeAs(
                        'ichijikin/' . $this->batch_name . '/' . $fileBaseName . '/resource',
                        $fileName,
                        $disk
                    );

                    IchijikinExtractionDetail::create([
                        'ichijikin_extraction_id' => $ichijikin->id,

                        'stored_name' => $fileBaseName,

                        'disk' => $disk,
                        'path' => $filePath,
                        'note' => null,

                        'extension' => $file->extension(),
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),

                        'checksum' => hash_file(
                            'sha256',
                            $file->getRealPath()
                        ),
                    ]);
                }
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

    public function render()
    {
        return view('livewire.ichijikin-extraction.detail');
    }
}
