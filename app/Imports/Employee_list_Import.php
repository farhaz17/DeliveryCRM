<?php

namespace App\Imports;
use App\Model\Employee_list;
use App\Model\UberEats;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Throwable;

class Employee_list_Import implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $data_partnumber=$this->checkExistData($this->getPartNumberId(trim($row['person_code'])));


//        dd($data_partnumber);
//         $part_number_array=array();
//        $part_quantity_array=array();
//        $part_quantity_balance_array=array();
//        $part_amount_array=array();

        if($data_partnumber == ""){
            $no_array=$row['no'];
            $person_code_array=trim($row['person_code']);
            $person_name_array=$row['person_name'];
            $job_array=$row['job'];
            $passport_details_array=$row['passport_details'];
            $card_details_array=$row['card_details'];
            return new Employee_list([
                'no' => $no_array,
                'person_code' => $person_code_array,
                'person_name' => $person_name_array,
                'job' => $job_array,
                'passport_details' => $passport_details_array,
                'card_details' => $card_details_array,
            ]);
        }
        else{

//            $quantitySet=$this->getQuantityBalance($data_partnumber);
//            $current_quantity=0;
//            $current_quantity_balance=0;




            $no=$row['no'];
            $person_code=trim($row['person_code']);
            $person_name=$row['person_name'];
            $job=$row['job'];
            $passport_details=$row['passport_details'];
            $card_details=$row['card_details'];

            $obj = Employee_list::find($data_partnumber);

            $obj->no=$no;
            $obj->person_code=$person_code;
            $obj->person_name=$person_name;
            $obj->job=$job;
            $obj->passport_details=$passport_details;
            $obj->card_details=$card_details;


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

    public function getPartNumberId($person_code){

        $trans_id = DB::table('employee_list_payment')->where('person_code', $person_code)->first();

        return optional($trans_id)->id;
    }

    public function checkExistData($person_code){

        $query=Employee_list::where('id', $person_code)->get()->first();

        $trans_id= isset($query->id)?$query->id:"";
        return $trans_id;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }

}
