<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class DcAssignRiders implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $view;
    public $assign_to_dc;

    public function __construct($view,$assign_to_dc)
    {
        $this->view = $view;
        $this->assign_to_dc = $assign_to_dc;
    }

    public function view(): View
    {

        return view($this->view)->with('assign_to_dc', $this->assign_to_dc);

    }
}
