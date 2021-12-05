<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalikUploadSheetAccount implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection  $rows)
    {
        $counter = 0;
        foreach ($rows as $row)
        {
            $counter = $counter+1;

                if($counter > 8){
                    break;
                }

        }
    }

}
