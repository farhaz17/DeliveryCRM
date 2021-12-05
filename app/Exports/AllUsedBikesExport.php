<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AllUsedBikesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$company_used_bike )
    {
        $this->view = $view;
        $this->company_used_bike = $company_used_bike;
    }

    public function view(): View
    {

        return view($this->view)->with('company_used_bike', $this->company_used_bike);
    }
}
