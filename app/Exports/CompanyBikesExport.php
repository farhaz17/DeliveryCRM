<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyBikesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$company_bike )
    {
        $this->view = $view;
        $this->company_bike = $company_bike;
    }

    public function view(): View
    {

        return view($this->view)->with('company_bike', $this->company_bike);
    }
}
