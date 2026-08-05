<?php

namespace App\Livewire\MasterData\Regency;

use App\Helpers\Alert;
use App\Helpers\AppCrypt;
use App\Repositories\MasterData\Regency\RegencyRepository;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Detail extends Component
{
    use WithFileUploads;

    public $objId;

    public $name;

    public function mount()
    {
        if ($this->objId) {

            $id = AppCrypt::decrypt($this->objId);
            if (!$id) {
                abort(404, 'Link tidak valid atau telah dimanipulasi.');
            }
            $regency = RegencyRepository::find($id);
            $this->name = $regency->name;
        }
    }

    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        if ($this->objId) {
            $this->redirectRoute('regency.edit', $this->objId);
        } else {
            $this->redirectRoute('regency.create');
        }
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        $this->redirectRoute('regency.index');
    }

    public function store()
    {
        try {
            DB::transaction(function () {
                // Vehicle
                $validateData = [
                    'name' => $this->name,
                ];
                $vehicle_id = null;
                if ($this->objId) {

                    $id = AppCrypt::decrypt($this->objId);
                    if (!$id) {
                        abort(404, 'Link tidak valid atau telah dimanipulasi.');
                    }
                    RegencyRepository::update($id, $validateData);
                } else {
                    $vehicle = RegencyRepository::create($validateData);
                    $vehicle_id = $vehicle->id;
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
        return view('livewire.master-data.regency.detail');
    }
}
