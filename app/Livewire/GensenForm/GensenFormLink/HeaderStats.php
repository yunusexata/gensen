<?php

namespace App\Livewire\GensenForm\GensenFormLink;

use App\Helpers\Alert;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormLink;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class HeaderStats extends Component
{

    public $data = [];
    public $pic_code;
    public $total;

    public function mount()
    {
        $this->status_choice = GensenFormLink::STATUS_CHOICE;

        $this->pic_code = Auth::user()->pic_code ?? null;
        $this->getDashboardStats();
    }

    private function getDashboardStats()
    {
        $this->total = GensenFormLink::query()
            ->when($this->pic_code, function ($q) {
                $q->where('pic_code', $this->pic_code);
            })
            ->selectRaw("
        COUNT(id) AS total,

        COUNT(id) FILTER (
            WHERE status = '" . GensenFormLink::STATUS_ACTIVE . "'
              AND expired_at > CURRENT_TIMESTAMP
        ) AS active,

        COUNT(id) FILTER (
            WHERE status = '" . GensenFormLink::STATUS_SUCCESS . "'
        ) AS success,

        COUNT(id) FILTER (
            WHERE status = '" . GensenFormLink::STATUS_EXPIRED . "'
               OR expired_at <= CURRENT_TIMESTAMP
        ) AS expired
    ")
            ->first()
            ->toArray();
    }
    public function render()
    {
        return view('livewire.gensen-form.gensen-form-link.header-stats');
    }
}
