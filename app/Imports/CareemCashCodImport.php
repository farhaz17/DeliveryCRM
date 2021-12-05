<?php

namespace App\Imports;

use App\Model\CareemCod;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Model\PlatformCode\PlatformCode;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CareemCashCodImport implements ToModel, WithStartRow //, WithBatchInserts, WithChunkReading
{
    use Importable, SkipsErrors;
    private  $fileName;
    public function __construct($fileName){
        $this->fileName = $fileName;
    }
    public function model(array $row){
        $platform_code  = PlatformCode::whereIn('platform_id', [1, 32])->wherePlatformCode($row[0])->first();
        if($platform_code){
            return new CareemCod([
                'passport_id' => $platform_code->passport_id,
                'type' => 1,
                'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
                'amount' => $row[2],
                'uploaded_file_path' => $this->fileName,
                'created_by' => auth()->id(),
                'data_stored_form' => 2
            ]);
        }else{
            return;
        }
    }
    // public function batchSize(): int
    // {
    //     return 1000;
    // }

    // public function chunkSize(): int
    // {
    //     return 1000;
    // }
    public function startRow(): int
    {
        return 2;
    }
}
