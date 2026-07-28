<?php

namespace App\Livewire\ListPosting;

use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Helpers\ExportHelper;
use App\Imports\ExcelImportBulkStatusGensen;
use App\Jobs\ResiGenerator\GetEmailJob;
use App\Models\GensenForm\GensenForm;
use App\Models\Ichijikin\IchijikinExtraction;
use App\Models\ResiGenerator\ResiGenerator;
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
        'mimes:xlsx,xls',
        'max:10240', // 10 MB
    ], message: [
        'required' => 'File Excel harus dipilih.',
        'file' => 'File tidak valid.',
        'mimes' => 'File harus berformat Excel (.xlsx atau .xls).',
        'max' => 'Ukuran file maksimal 10 MB.',
    ])]
    public $file_excel;

    public function mount()
    {
        if ($this->objId) {
            $list_posting = ResiGeneratorRepository::find(Crypt::decrypt($this->objId));
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

            $resi = ResiGeneratorRepository::create([
                'label' => $this->label,
                'bank' => $this->bank,

                'source_file_name' => $storedName,
                'source_file_disk' => $disk,
                'source_file_path' => $path,
                'get_email_status' => JobStatus::PENDING,
                'matching_status' => JobStatus::PENDING,
                'zip_status' => JobStatus::PENDING,
            ]);

            $import = new ExcelImportBulkStatusGensen();
            Excel::import($import, $this->file_excel);

            foreach ($import->rows as $index => $row) {
                $validatedData = [
                    'resi_generator_id' => $resi->id,
                    'nama_penerima' => $row['nama_penerima'],
                    'no' => $row['no'],
                    'jenis_pencairan' => $row['jenis_pencairan'],
                    'nama' => $row['nama'],
                    'nominal' => $row['nominal'],
                    'rekening' => $row['rekening'],
                    'bank' => $row['bank'],
                    'is_matched' => false,
                    'status' => JobStatus::PENDING,
                ];

                if ($validatedData['nominal'] && $validatedData['no']) {
                    ResiGeneratorDetailRepository::create($validatedData);
                }
            }

            GetEmailJob::dispatch($resi)->onQueue('extract');
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
        return view('livewire.list-posting.detail');
    }
}
