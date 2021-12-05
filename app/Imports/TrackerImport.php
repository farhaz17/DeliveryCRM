<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Model\Master\Vehicle\VehicleTrackingInventory;

class TrackerImport implements ToModel, WithStartRow
{
    use Importable, SkipsErrors;

    private  $fileName;
    private  $id;

    public function __construct($fileName, $id){
        $this->fileName = $fileName;
        $this->id = $id;
    }

    public function model(array $row){

        return new VehicleTrackingInventory([
            'tracking_no' => $row[0],
            'lpo_id' => $this->id,
            'uploaded_file_path' => $this->fileName,
        ]);

    }

    public function startRow(): int
    {
        return 2;
    }
}
