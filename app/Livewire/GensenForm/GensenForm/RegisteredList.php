<?php

namespace App\Livewire\GensenForm\GensenForm;

use App\Helpers\Alert;
use App\Models\GensenForm\GensenFormLink;
use App\Models\User;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use App\Repositories\MasterData\Regency\RegencyRepository;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisteredList extends Component
{
    use WithFileUploads;

    public $token;
    public $gensenFormId;

    public $data = [];

    public function mount()
    {
        if ($this->gensenFormId) {
            $this->data = [];
            // $gensenForm = GensenFormRepository::find(Crypt::decrypt($this->gensenFormId));
        }
        if ($this->token) {
            $token = simple_decrypt($this->token);
            $this->data = GensenFormLinkRepository::findBy([
                ['token', $token]
            ])->gensenForms->toArray();
        }
    }

    public function render()
    {
        return view('livewire.gensen-form.gensen-form.registered-list');
    }
}
