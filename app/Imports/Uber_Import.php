<?php

namespace App\Imports;



use App\Model\Fines;

use App\Model\Uber;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Throwable;

class Uber_Import implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $data_partnumber=$this->checkExistData($this->getPartNumberId( trim($row['name'])));


//        dd($data_partnumber);
//         $part_number_array=array();
//        $part_quantity_array=array();
//        $part_quantity_balance_array=array();
//        $part_amount_array=array();

        if($data_partnumber == ""){
            $name_array= trim($row['name']);
            $cash_array=$row['cash'];
            $credit_array=$row['credit'];
            return new Uber([
                'name'  => $name_array,
                'cash'  => $cash_array,
                'credit'  => $credit_array,
            ]);
        }
        else{

//            $quantitySet=$this->getQuantityBalance($data_partnumber);
//            $current_quantity=0;
//            $current_quantity_balance=0;




            $name= trim($row['name']);
            $cash=$row['cash'];
            $credit=$row['credit'];

            $obj = Uber::find($data_partnumber);

            $obj->name=$name;
            $obj->cash=$cash;
            $obj->credit=$credit;
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

    public function getPartNumberId($uber){

        $trans_id = DB::table('uber')->where('name', $uber)->first();
        return optional($trans_id)->id;
    }

    public function checkExistData($uber){

        $query=Uber::where('id', $uber)->get()->first();

        $trans_id= isset($query->id)?$query->id:"";
        return $trans_id;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }

}
