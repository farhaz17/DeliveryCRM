<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyFreeBikesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$company_free_bike )
    {
        $this->view = $view;
        $this->company_free_bike = $company_free_bike;
    }

    public function view(): View
    {

        return view($this->view)->with('company_free_bike', $this->company_free_bike);
    }
}
