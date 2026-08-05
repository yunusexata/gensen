<?php

namespace App\Livewire\TemplatePosting;

use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Helpers\AppCrypt;
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
    #[Validate('required', message: 'Jenis Template Harus Diisi', onUpdate: false)]
    public $type;
    #[Validate([
        'nullable',
        'file',
        'max:10240', // 10 MB
    ], message: [
        'file' => 'File tidak valid.',
        'max' => 'Ukuran file maksimal 10 MB.',
    ])]
    public $file_template;
    public $file_template_path;

    public $config = [
        'list' => [
            'color' => '#000000',
        ],
        'page' => [
            'color' => '#000000',
        ]
    ];

    public function mount()
    {
        if ($this->objId) {

            $id = AppCrypt::decrypt($this->objId);
            if (!$id) {
                abort(404, 'Link tidak valid atau telah dimanipulasi.');
            }
            $template_posting = TemplatePostingRepository::find($id);
            $this->name = $template_posting->name;
            $this->type = $template_posting->type;
            $this->config = $template_posting->config;
            $this->file_template_path = $template_posting->previewUrl();
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
            $validatedData = [
                'name' => $this->name,
                'type' => $this->type,
                'config' => $this->config,
            ];

            if ($this->file_template) {
                $disk = 'private';

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

                $validatedData['disk'] = $disk;
                $validatedData['path'] = $path;
            }
            if ($this->objId) {

                $id = AppCrypt::decrypt($this->objId);
                if (!$id) {
                    abort(404, 'Link tidak valid atau telah dimanipulasi.');
                }
                TemplatePostingRepository::update($id, $validatedData);
            } else {

                TemplatePostingRepository::create($validatedData);
            }


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
