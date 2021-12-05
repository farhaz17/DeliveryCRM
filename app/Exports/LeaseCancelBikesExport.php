<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class LeaseCancelBikesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$lease_cancel_bike )
    {
        $this->view = $view;
        $this->lease_cancel_bike = $lease_cancel_bike;
    }

    public function view(): View
    {

        return view($this->view)->with('lease_cancel_bike', $this->lease_cancel_bike);
    }
}
