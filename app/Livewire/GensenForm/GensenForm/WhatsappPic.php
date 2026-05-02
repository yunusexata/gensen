<?php

namespace App\Livewire\GensenForm\GensenForm;

use App\Repositories\GensenForm\GensenFormLinkRepository;
use Livewire\Component;

class WhatsappPic extends Component
{

    public $token;

    public $phone;

    public function mount()
    {
        if ($this->token) {
            $token = simple_decrypt($this->token);
            $this->phone = GensenFormLinkRepository::findBy([
                ['token', $token]
            ])->creator->no_whatsapp;
        }
    }

    public function render()
    {
        return view('livewire.gensen-form.gensen-form.whatsapp-pic');
    }
}
