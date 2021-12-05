<?php

namespace App\Imports;

use App\Model\Cities;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Model\PlatformCode\PlatformCode;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use App\Model\TalabatCod\TalabatCodInternal;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TalabatCodInternalImport implements ToModel, WithStartRow
{
    use Importable, SkipsErrors;
    private  $start_date;
    private  $end_date;
    private  $fileName;
    public function __construct($start_date, $end_date, $fileName){
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->fileName = $fileName;
    }
    public function model(array $row){
        $platform_code = PlatformCode::whereIn('platform_id',[15,34,41])->wherePlatformCode($row[2])->first(); // Rider ID
        if(!$platform_code) return;
        return new TalabatCodInternal([
            'passport_id' => $platform_code->passport->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'uploaded_file_path' => $this->fileName,
            'upload_by' => auth()->id(),
            'city_id' => Cities::firstOrCreate(['name' => trim($row[0])], ['name' => trim($row[0])])->id,
            'courier_name' => $row[1],
            'platform_code' => $row[4],
            'cash' => $row[3],
            'bank' => $row[4],
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
