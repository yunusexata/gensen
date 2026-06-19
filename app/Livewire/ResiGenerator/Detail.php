<?php

namespace App\Livewire\ResiGenerator;

use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Helpers\ExportHelper;
use App\Models\GensenForm\GensenForm;
use App\Models\Ichijikin\IchijikinExtraction;
use App\Models\ResiGenerator\ResiGenerator;
use App\Repositories\ResiGenerator\ResiGeneratorRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Detail extends Component
{

    public $objId;

    #[Validate('required', message: 'Nama Label Email Harus Diisi', onUpdate: false)]
    public $label;
    #[Validate('required', message: 'Nama Bank Harus Diisi', onUpdate: false)]
    public $bank;

    public function mount()
    {
        if ($this->objId) {
            $resi_generator = ResiGeneratorRepository::find(Crypt::decrypt($this->objId));
            $this->label = $resi_generator->label;
            $this->bank = $resi_generator->bank;
        }
    }

    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        if ($this->objId) {
            $this->redirectRoute('resi_generator.edit', $this->objId);
        } else {
            $this->redirectRoute('resi_generator.create');
        }
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        $this->redirectRoute('resi_generator.index');
    }


    public function store()
    {
        $this->validate();
        try {
            DB::transaction(function () {

                // Vehicle
                $validateData = [

                    'label' => $this->label,
                    'bank' => $this->bank,
                    'status' => JobStatus::PENDING
                ];

                if ($this->objId) {
                    $resi_id = Crypt::decrypt($this->objId);
                    ResiGenerator::update($resi_id, $validateData);
                } else {
                    $resi = ResiGenerator::create($validateData);
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
        return view('livewire.resi-generator.detail');
    }
}
