<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TotalSimsRiderExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$rider_sim )
    {
        $this->view = $view;
        $this->rider_sim = $rider_sim;
    }

    public function view(): View
    {

        return view($this->view)->with('rider_sim', $this->rider_sim);
    }
}
