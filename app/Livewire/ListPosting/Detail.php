<?php

namespace App\Livewire\ListPosting;

use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Helpers\AppCrypt;
use App\Imports\ExcelImportListPosting;
use App\Repositories\ListPosting\ListPostingRepository;
use App\Repositories\ListPosting\TemplatePostingRepository;
use App\Repositories\ResiGenerator\ResiGeneratorRepository;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Detail extends Component
{

    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $objId;

    #[Validate('required', message: 'Nama / Judul Harus Diisi', onUpdate: false)]
    public $name;
    #[Validate([
        'required',
        'file',
        'mimes:xlsx,xls',
        'max:10240', // 10 MB
    ], message: [
        'required' => 'File Excel harus dipilih.',
        'file' => 'File tidak valid.',
        'mimes' => 'File harus berformat Excel (.xlsx atau .xls).',
        'max' => 'Ukuran file maksimal 10 MB.',
    ])]
    public $file_excel;

    // public $templates = [];
    public $template_posting_id;

    public function mount()
    {
        // $this->templates = TemplatePostingRepository::all();
        if ($this->objId) {
            $id = AppCrypt::decrypt($this->objId);
            if (!$id) {
                abort(404, 'Link tidak valid atau telah dimanipulasi.');
            }
            $list_posting = ResiGeneratorRepository::find($id);
            $this->name = $list_posting->name;
        }
    }

    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        if ($this->objId) {
            $this->redirectRoute('list_posting.edit', $this->objId);
        } else {
            $this->redirectRoute('list_posting.create');
        }
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        $this->redirectRoute('list_posting.index');
    }


    public function store()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $disk = 'private';

            $storedName = $this->name . '_' . Str::uuid() . '.' . $this->file_excel->extension();
            $filePath =   "list_posting/excel";

            $path = Storage::disk($disk)->putFileAs(
                $filePath,
                $this->file_excel,
                $storedName,
                [
                    'visibility' => 'private',
                ]
            );

            $list = ListPostingRepository::create([
                'template_posting_id' => $this->template_posting_id,
                'name' => $this->name,
                'zip_status' => JobStatus::PENDING,
            ]);

            $import = new ExcelImportListPosting($list->id, $path);
            Excel::queueImport($import, $this->file_excel);
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
        $templates = TemplatePostingRepository::latest('created_at')->paginate(8);

        return view('livewire.list-posting.detail', [
            'templates' => $templates
        ]);
    }
}
