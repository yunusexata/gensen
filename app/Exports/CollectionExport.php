<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class CollectionExport implements FromView, WithColumnWidths
{
    private $view;

    private $query;

    private $request;

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'C' => 20,
        ];
    }
    public function __construct($request, $query, $view)
    {
        $this->request = $request;
        $this->query = $query;
        $this->view = $view;
    }

    public function view(): View
    {
        return view($this->view, [
            'request' => $this->request,
            'collection' => $this->query->get(),
            'number_format' => false,
        ]);
    }
}
