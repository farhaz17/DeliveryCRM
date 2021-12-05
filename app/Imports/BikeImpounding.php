<?php

namespace App\Imports;

use DateTime;
use App\Model\BikeDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Model\BikeImpounding\BikeImpoundingUpload;

class BikeImpounding implements ToModel ,WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    use Importable, SkipsErrors;

    private  $last_id = "";
    private $message = '';

    public function __construct($last_id)
    {

        $this->last_id = $last_id;

    }


    public function model(array $row)
    {
//dd($row);
        $trans_id =  $this->checkExistData($row['ticket_number']);
        if($trans_id=="" && $row['ticket_number']!=null &&  $row['number_of_days_of_booking']!=null){
            $array_explode = explode(" ",$row['ticket_date']);

            $date_s = DateTime::createFromFormat('d/m/Y',$array_explode[0]);

            $plate_explode = explode(" ",$row['plate_number']);

            $bike = BikeDetail::where('plate_no', $plate_explode)->first();

            if(!$bike) {
                $this->message .=  $plate_explode[0] . " Plate No not found ";
            } else{
                $date_s =  $date_s->format('Y-m-d');

                return new BikeImpoundingUpload([
                    'bike_impounding_upload_file_path_id'  =>  $this->last_id,
                    'plate_number'  => $plate_explode[0],
                    'plate_category'  => $plate_explode[1],
                    'ticket_number'  => $row['ticket_number'],
                    'ticket_date'  => $date_s,
                    'ticket_time'  => $array_explode[1],
                    'value_instead_of_booking' => $row['value_instead_of_booking'],
                    'number_of_days_of_booking' =>  $row['number_of_days_of_booking'],
                    'text_violation' => $row['text_violation']
                ]);
            }

        }else{
            return  null;
        }


    }


    public function getMessage()
    {
        return $this->message;
    }

    public function checkExistData($ticket_number){

        $query= BikeImpoundingUpload::where('ticket_number', '=', $ticket_number)->first();

        $trans_id = isset($query->id)?$query->id:"";

        return $trans_id;

    }
}
