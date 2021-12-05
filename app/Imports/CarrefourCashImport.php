<?php

namespace App\Imports;

use App\CarrefourCashImports;
use App\Model\Carrefour\CarrefourCod;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Model\PlatformCode\PlatformCode;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CarrefourCashImport implements ToModel, WithStartRow
{
    use Importable, SkipsErrors;
    private  $start_date;
    private  $end_date;
    public function __construct($start_date ,$end_date){
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function model(array $row)
    {
        if(empty($row[0]) || $row[2]=="0" ||  $row[2]==null){

            return null;
        }
        $platform_code = PlatformCode::where('platform_id','38')->wherePlatformCode($row[0])->first(); // Rider ID
        if(!$platform_code) return;
        return new CarrefourCod([
            'passport_id' => $platform_code->passport->id,
            'rider_id' => $row[0],
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
            // 'time' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2])->format('H:i'),
            'amount' => $row[2], //amount
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
