<?php

namespace App\Livewire\IchijikinExtraction;

use App\Helpers\Alert;
use App\Models\Exata\ExataFormCandidate;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormLink;
use App\Models\Ichijikin\IchijikinExtraction;
use App\Repositories\Exata\ExataFormCandidateRepository;
use App\Repositories\GensenForm\GensenFormLinkRepository;
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

    public function mount() {}

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
                $disk = 'private';

                $extension = $this->file_ichijikin
                    ->extension();

                $fileName =  'ICHIJIKIN EXTRACTION - ' . $this->batch_name . ' - ' . now()->format('Ymd') . ' - ' . Str::uuid() . '.' . $extension;
                $filePath = Storage::disk($disk)->putFileAs(
                    'exports/gensen/template_dalam_pengajuan',
                    $this->inputFileBulkStatus,
                    $fileName,
                    [
                        'visibility' => 'private',
                    ]
                );
                // Vehicle
                $validateData = [

                    'batch_name' => $this->batch_name,
                    'stored_name' => $fileName,
                    'description' => null,

                    'disk' => $this->batch_name,
                    'path' => $this->batch_name,
                    'note' => $this->batch_name,

                    'extension' => $this->file_ichijikin->extension(),
                    'mime_type' => $this->file_ichijikin->getMimeType(),
                    'file_size' => $this->file_ichijikin->getSize(),

                    'checksum' => hash_file('sha256', $this->file_ichijikin->getRealPath()),
                ];

                if ($this->objId) {
                    $ichijin_id = Crypt::decrypt($this->objId);
                    IchijikinExtraction::update($ichijin_id, $validateData);
                } else {
                    $ichijikin = IchijikinExtraction::create($validateData);
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
