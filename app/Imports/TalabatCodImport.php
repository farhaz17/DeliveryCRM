<?php

namespace App\Imports;

use App\Model\Cities;
use App\Model\RiderZone\Zone;
use App\Imports\TalabatCodImport;
use App\Model\TalabatCod\TalabatCod;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Model\PlatformCode\PlatformCode;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithStartRow;


class TalabatCodImport implements ToModel, WithStartRow
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
        if(!$platform_code) return;
        return new TalabatCod([
            'city_id' => Cities::firstOrCreate(['name' => trim($row[1])], ['name' => trim($row[1])])->id, //$row[1],
            'zone_id' => Zone::firstOrCreate(['name' => trim($row[2])],['name' => trim($row[2])])->id, //$row[2],
            'passport_id' => $platform_code->passport->id,
            'rider_name' => $row[3],
            'platform_code' => $row[4],
            'rider_status' => $row[5],
            'vendor' => $row[6],
            'previous_day_pending' => number_format((float)$row[7], 2, '.', ''), // pending_as_on_18_may
            'current_day_cash_deposit' => number_format((float)$row[8], 2, '.', ''), // cash_deposit_19_may
            'previous_day_balance' => number_format((float)$row[9], 2, '.', ''), // balance_as_on_18_may
            'current_day_adjustment' => number_format((float)$row[10], 2, '.', ''), // adjustments_19_may
            'current_day_cod' => number_format((float)$row[11], 2, '.', ''), // 19_may_cod
            'tips' => number_format((float)$row[12], 2, '.', ''), // 19_may_tips
            'current_day_balance' => number_format((float)$row[13], 2, '.', ''), //pending_as_on_19_may
            'deposit_status' => $row[14], // deposit_status_19_may
            'days_delayed' => $row[15], // days_delayed_19_may
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'upload_by' => auth()->id(),
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
