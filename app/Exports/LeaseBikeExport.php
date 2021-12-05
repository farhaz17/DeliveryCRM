<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class LeaseBikeExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$lease_bike )
    {
        $this->view = $view;
        $this->lease_bike = $lease_bike;
    }

    public function view(): View
    {

        return view($this->view)->with('lease_bike', $this->lease_bike);
    }
}
