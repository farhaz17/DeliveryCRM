<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class SalikUploadAccount implements ToCollection, WithMappedCells
{

    public function mapping(): array
    {
        return [
            'account_no'  => 'c6',
            'from_date_and_end_date' => 'c7',
        ];
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
}
