<?php

namespace App\Imports;

//use App\Model\FineUpload\FineUploadTrafficeCode;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FineUploadTrafficCode implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {


        foreach ($rows as $row)
        {
            $trans_id = $this->checkExistData($row['traffic_file_no']);

            break;
        }
    }

    public function headingRow()
    {
        return 1;
    }

    public function checkExistData($ticket_number){

//        $gamer = \App\Model\FineUpload\FineUploadTrafficeCode::where('traffic_file_no','=',$ticket_number)->first();
//
//        if($gamer==null){
             $player = new  \App\Model\FineUpload\FineUploadTrafficeCode();
            $player->traffic_file_no = $ticket_number;
            $player->save();
//        }


        return "";
    }



}
