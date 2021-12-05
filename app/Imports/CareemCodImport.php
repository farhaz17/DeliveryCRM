<?php

namespace App\Imports;

use App\Model\Careem;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Model\PlatformCode\PlatformCode;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CareemCodImport implements ToModel, WithStartRow
{
    use Importable, SkipsErrors;
    private  $start_date;
    private  $end_date;
    public function __construct($start_date ,$end_date){
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function model(array $row){
        // $cash = $row[8];
        // if($cash >= 0) {
        //     $cashs = $cash < 0 ? $cash : -$cash;
        // }
        // elseif($cash < 0) {
        //     $cashs = abs($cash);
        // }
        // dd($cashs);
        if(empty($row[2]) || $row[11]=="0" ||  $row[11]==null){

            return null;
        }
        $platform_code = PlatformCode::whereIn('platform_id',[1,32])->wherePlatformCode($row[2])->first(); // Rider ID
        if(!$platform_code) return;
        return new Careem([
            // 'payment_id' => $row[0],
            'driver_id' => $row[2],
            // 'total_driver_base_cost' => $row[7], //total cod
            'total_driver_other_cost' => $row[11], //cash
            // 'total_driver_payment' => $row[9], //bank
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'passport_id' => $platform_code->passport->id,
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
