<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TotalSimsOfficeExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$office_sim )
    {
        $this->view = $view;
        $this->office_sim = $office_sim;
    }

    public function view(): View
    {

        return view($this->view)->with('office_sim', $this->office_sim);
    }
}
