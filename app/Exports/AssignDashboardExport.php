<?php

namespace App\Exports;

use App\Model\BikeDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AssignDashboardExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
//    public function collection()
//    {
//        //
//        return $all_bikes = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->get();
//    }
    public function __construct($view,$all_bikes )
    {
        $this->view = $view;
        $this->all_bikes = $all_bikes;
    }

    public function view(): View
    {

        return view($this->view)->with('all_bikes', $this->all_bikes);
    }


}
