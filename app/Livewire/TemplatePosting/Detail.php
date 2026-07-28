<?php

namespace App\Livewire\TemplatePosting;

use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Imports\ExcelImportBulkStatusGensen;
use App\Jobs\ResiGenerator\GetEmailJob;
use App\Repositories\ListPosting\TemplatePostingRepository;
use App\Repositories\ResiGenerator\ResiGeneratorDetailRepository;
use App\Repositories\ResiGenerator\ResiGeneratorRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Detail extends Component
{

    use WithFileUploads;

    public $objId;

    #[Validate('required', message: 'Nama / Judul Harus Diisi', onUpdate: false)]
    public $name;
    #[Validate([
        'required',
        'file',
        'max:10240', // 10 MB
    ], message: [
        'required' => 'File Excel harus dipilih.',
        'file' => 'File tidak valid.',
        'max' => 'Ukuran file maksimal 10 MB.',
    ])]
    public $file_template;

    public function mount()
    {
        if ($this->objId) {
            $template_posting = TemplatePostingRepository::find(Crypt::decrypt($this->objId));
            $this->name = $template_posting->label;
        }
    }

    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        if ($this->objId) {
            $this->redirectRoute('template_posting.edit', $this->objId);
        } else {
            $this->redirectRoute('template_posting.create');
        }
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        $this->redirectRoute('template_posting.index');
    }


    public function store()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $disk = env('DEFAULT_STORE_DISK', 'private');

            $storedName = $this->name . '_' . Str::uuid() . '.' . $this->file_template->extension();
            $filePath =   "list_posting/template";

            $path = Storage::disk($disk)->putFileAs(
                $filePath,
                $this->file_template,
                $storedName,
                [
                    'visibility' => 'private',
                ]
            );

            TemplatePostingRepository::create([
                'name' => $this->name,

                'disk' => $disk,
                'path' => $path,
            ]);

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
        return view('livewire.template-posting.detail');
    }
}
