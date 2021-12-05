<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;


class TotalSimsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

        //
        public function __construct($view,$total_sim )
    {
        $this->view = $view;
        $this->total_sim = $total_sim;
    }

        public function view(): View
    {

        return view($this->view)->with('total_sim', $this->total_sim);
    }

}
