<?php

namespace App\Livewire\GensenForm\GensenFormLink;

use App\Helpers\Alert;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormLink;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class HeaderStats extends Component
{

    public $data = [];

    public function mount()
    {
        $this->status_choice = GensenFormLink::STATUS_CHOICE;
    }

    public function render()
    {
        return view('livewire.gensen-form.gensen-form-link.filter');
    }
}
