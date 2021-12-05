<?php

namespace App\Imports;

use App\Model\Cities;
use App\Model\RiderZone\Zone;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Model\PlatformCode\PlatformCode;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Model\TalabatCod\TalabatCodDeduction;

class TalabatCodDeductionImport implements ToModel, WithStartRow
{
    use Importable, SkipsErrors;
    private  $start_date;
    private  $end_date;
    public function __construct($start_date ,$end_date){
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }
    public function model(array $row){
        $platform_code = PlatformCode::whereIn('platform_id',[15,34,41])->wherePlatformCode($row[4])->first(); // Rider ID
        if($platform_code){
            return new TalabatCodDeduction([
                'city_id' => Cities::firstOrCreate(['name' => trim($row[1])], ['name' => trim($row[1])])->id, //$row[1],
                'zone_id' => Zone::firstOrCreate(['name' => trim($row[2])],['name' => trim($row[2])])->id, //$row[2],
                'passport_id' => $platform_code->passport_id,
                'rider_name' => $row[3],
                'platform_code' => $row[4],
                'rider_status' => $row[5],
                'vendor' => $row[6],
                'deduction' => number_format($row[7], 2, '.', ''), // deduction_as_on_18_may
                'deposit_status' => $row[8], // deposit_status_19_may
                'days_delayed' => $row[9] ?? 0, // days_delayed_19_may
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'upload_by' => auth()->id(),
            ]);
        }else{
            return;
        }
    }
    public function startRow(): int
    {
        return 2;
    }

}
