<?php

namespace App\Imports;

use App\SalikImport;
use App\Model\Lpo\SalikTag;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SalikImports implements ToModel, WithStartRow
{
    use Importable, SkipsErrors;

    private  $fileName;
    public function __construct($fileName){
        $this->fileName = $fileName;
    }

    public function model(array $row){

        if($row[0]==null){
            return null;
        }

        return new SalikTag([
            'tag_no' => $row[0],
            'uploaded_file_path' => $this->fileName,
        ]);

    }

    public function startRow(): int
    {
        return 2;
    }
}
