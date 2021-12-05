<?php

namespace App\Imports;



use App\Model\Fines;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Throwable;

class FinesImport implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $data_partnumber=$this->checkExistData($this->getPartNumberId(trim($row['ticket_number'])));


//        dd($data_partnumber);
//         $part_number_array=array();
//        $part_quantity_array=array();
//        $part_quantity_balance_array=array();
//        $part_amount_array=array();

        if($data_partnumber == ""){
            $trafic_file_no_array=$row['traffic_file_no'];

            $plate_number_array=$row['plate_number'];
            $plate_category_array=$row['plate_category'];
            $plate_code_array=$row['plate_code'];
            $license_no_array=$row['license_number'];
            $license_from_array=$row['license_from'];
            $ticket_number_array=trim($row['ticket_number']);
            $ticket_date_array=$row['ticket_date'];
            $fines_source_array=$row['fines_source'];
            $ticket_fee_array=$row['ticket_fee'];
            $ticket_status_array=$row['ticket_status'];
            $offence_terms_array=$row['the_terms_of_the_offense'];
            return new Fines([
                'traffic_file_no'  => $trafic_file_no_array,
                'plate_number'  => $plate_number_array,
                'plate_category'  => $plate_category_array,
                'plate_code'  => $plate_code_array,
                'license_number'  => $license_no_array,
                'license_from'  => $license_from_array,
                'ticket_number'  => $ticket_number_array,
                'ticket_date'  => $ticket_date_array,
                'fines_source'  => $fines_source_array,
                'ticket_fee'  => $ticket_fee_array,
                'ticket_status'  => $ticket_status_array,
                'the_terms_of_the_offense'  => $offence_terms_array,

            ]);
        }
        else{

//            $quantitySet=$this->getQuantityBalance($data_partnumber);
//            $current_quantity=0;
//            $current_quantity_balance=0;




            $trafic_file_no=$row['traffic_file_no'];
            $plate_number=$row['plate_number'];
            $plate_category=$row['plate_category'];
            $plate_code=$row['plate_code'];
            $license_no=$row['license_number'];
            $license_from=$row['license_from'];
            $ticket_number=trim($row['ticket_number']);
            $ticket_date=$row['ticket_date'];
            $fines_source=$row['fines_source'];
            $ticket_fee=$row['ticket_fee'];
            $ticket_status=$row['ticket_status'];
            $offence_terms=$row['the_terms_of_the_offense'];

            $obj = Fines::find($data_partnumber);
            $obj->traffic_file_no=$trafic_file_no;
            $obj->plate_number=$plate_number;
            $obj->plate_category=$plate_category;
            $obj->plate_code=$plate_code;
            $obj->license_number=$license_no;
            $obj->license_from=$license_from;
            $obj->ticket_number=$ticket_number;
            $obj->ticket_date=$ticket_date;
            $obj->fines_source=$fines_source;
            $obj->ticket_fee=$ticket_fee;
            $obj->ticket_status=$ticket_status;
            $obj->the_terms_of_the_offense=$offence_terms;
//dd($obj);

            $obj->save();

//            $message = [
//                'message' => 'Updated Successfully',
//                'alert-type' => 'success'
//
//            ];
//            return redirect()->route('form_upload')->with($message);
        }


    }

    public function getPartNumberId($ticket_number){

        $trans_id = DB::table('fines')->where('ticket_number', $ticket_number)->first();

        return optional($trans_id)->id;
    }

    public function checkExistData($ticket_number){

        $query=Fines::where('id', $ticket_number)->get()->first();

        $trans_id= isset($query->id)?$query->id:"";
        return $trans_id;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }

}
