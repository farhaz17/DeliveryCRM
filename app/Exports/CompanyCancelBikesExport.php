<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyCancelBikesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$company_cancel_bike )
    {
        $this->view = $view;
        $this->company_cancel_bike = $company_cancel_bike;
    }

    public function view(): View
    {

        return view($this->view)->with('company_cancel_bike', $this->company_cancel_bike);
    }
}
