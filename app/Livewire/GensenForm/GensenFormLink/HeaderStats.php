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
        COALESCE(SUM(max_usage), 0) AS total,

        COALESCE(SUM(used_count), 0) AS submit,
        
        COALESCE(COUNT(
                CASE
                    WHEN status = '" . GensenFormLink::STATUS_ACTIVE . "'
                    AND expired_at > CURRENT_TIMESTAMP
                    THEN 1
                    ELSE NULL
                END
            ), 0) AS active,

        COALESCE(SUM(
            CASE
                WHEN expired_at <= CURRENT_TIMESTAMP
                THEN GREATEST(max_usage - used_count, 0)
                ELSE 0
            END
        ), 0) AS expired
    ")
            ->first()
            ->toArray();
        // dd($this->total);
    }
    public function render()
    {
        return view('livewire.gensen-form.gensen-form-link.header-stats');
    }
}
