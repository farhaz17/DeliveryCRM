<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TotalSimsFreeExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$free_sim )
    {
        $this->view = $view;
        $this->free_sim = $free_sim;
    }

    public function view(): View
    {

        return view($this->view)->with('free_sim', $this->free_sim);
    }
}
