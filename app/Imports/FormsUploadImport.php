<?php

namespace App\Imports;



use App\Model\Vehicle_salik;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Throwable;

class FormsUploadImport implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $data_partnumber=$this->checkExistData($this->getPartNumberId(trim($row['transaction_id'])));


//        dd($data_partnumber);
//         $part_number_array=array();
//        $part_quantity_array=array();
//        $part_quantity_balance_array=array();
//        $part_amount_array=array();

        if($data_partnumber == ""){
            $transaction_id_array=trim($row['transaction_id']);
            $trip_date_array=$row['trip_date'];
            $trip_time_array=$row['trip_time'];
            $transaction_post_date_array=$row['transaction_post_date'];
            $toll_gate_array=$row['toll_gate'];
            $direction_array=$row['direction'];
            $tag_array=$row['tag_number'];
            $plate_array=$row['plate'];
            $amount_array=$row['amount'];
            $account_array=$row['account_number'];
            return new Vehicle_salik([
                'transaction_id'  => $transaction_id_array,
            'trip_date'  => $trip_date_array,
            'trip_time'  => $trip_time_array,
            'transaction_post_date'  => $transaction_post_date_array,
            'toll_gate'  => $toll_gate_array,
            'direction'  => $direction_array,
            'tag_number'  => $tag_array,
            'plate'  => $plate_array,
            'amount'  => $amount_array,
            'account_number'  => $account_array,
            ]);
        }
        else{

//            $quantitySet=$this->getQuantityBalance($data_partnumber);
//            $current_quantity=0;
//            $current_quantity_balance=0;


            $transaction_id = trim($row['transaction_id']);
            $trip_date=$row['trip_date'];
            $trip_time=$row['trip_time'];
            $transaction_post_date=$row['transaction_post_date'];
            $toll_gate=$row['toll_gate'];
            $direction=$row['direction'];
            $tag_number=$row['tag_number'];
            $plate=$row['plate'];
            $amount=$row['amount'];
            $account_number=$row['account_number'];



            $obj = Vehicle_salik::find($data_partnumber);
//dd($obj);
         //   $obj=new Vehicle_salik();
            $obj->transaction_id=$transaction_id;
            $obj->trip_date=$trip_date;
            $obj->trip_time=$trip_time;
            $obj->transaction_post_date=$transaction_post_date;
            $obj->toll_gate=$toll_gate;
            $obj->direction=$direction;
            $obj->tag_number=$tag_number;
            $obj->plate=$plate;
            $obj->amount=$amount;
            $obj->account_number=$account_number;
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

    public function getPartNumberId($transaction_id){

        $trans_id = DB::table('vehicle_saliks')->where('transaction_id', $transaction_id)->first();
        return optional($trans_id)->id;
    }

    public function checkExistData($transaction_id){

        $query=Vehicle_salik::where('id', $transaction_id)->get()->first();

        $trans_id= isset($query->id)?$query->id:"";
        return $trans_id;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }

}
