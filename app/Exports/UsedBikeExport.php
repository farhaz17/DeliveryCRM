<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UsedBikeExport  implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($view,$lease_used_bike )
    {
        $this->view = $view;
        $this->lease_used_bike = $lease_used_bike;
    }

    public function view(): View
    {

        return view($this->view)->with('lease_used_bike', $this->lease_used_bike);
    }
}
