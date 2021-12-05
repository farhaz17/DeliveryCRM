<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class FreeLeaseBikesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$lease_free_bike )
    {
        $this->view = $view;
        $this->lease_free_bike = $lease_free_bike;
    }

    public function view(): View
    {

        return view($this->view)->with('lease_free_bike', $this->lease_free_bike);
    }
}
