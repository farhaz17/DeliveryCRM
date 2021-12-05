<?php

namespace App\Imports;


use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;


class LabourUpload implements ToModel,WithHeadingRow
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


        if($data_partnumber == ""){

            $excel_date = $row['labour_card_expiry']; //here is that value 41621 or 41631
            $unix_date = ($excel_date - 25569) * 86400;
            $excel_date = 25569 + ($unix_date / 86400);
            $unix_date = ($excel_date - 25569) * 86400;



            $person_code_array=$row['person_code'];
            $person_name_array=$row['person_name'];
            $job_array=$row['job'];
            $passport_array=$row['passport'];
            $nationality_array=$row['nationality'];
            $labour_card_array=$row['labour_card'];
            $labour_card_expiry_array=$row['labour_card_expiry'];
            $card_type_array=$row['card_type'];
            $class_array=$row['class'];
            $company_no_array=$row['company_no'];

            return new \App\Model\LabourUpload([
                'person_code'  => $person_code_array,
                'person_name'  => $person_name_array,
                'job'  => $job_array,
                'passport'  => $passport_array,
                'nationality'  => trim($nationality_array),
                'labour_card'  => $labour_card_array,
                'labour_card_expiry'  => gmdate("Y-m-d", $unix_date),
                'card_type'  => $card_type_array,
                'class'  => $class_array,
                'company_no'  => $company_no_array,


            ]);
        }
        else{

//            $quantitySet=$this->getQuantityBalance($data_partnumber);
//            $current_quantity=0;
//            $current_quantity_balance=0;

            $excel_date = $row['labour_card_expiry'];; //here is that value 41621 or 41631
            $unix_date = ($excel_date - 25569) * 86400;
            $excel_date = 25569 + ($unix_date / 86400);
            $unix_date = ($excel_date - 25569) * 86400;


            $person_code=$row['person_code'];
            $person_name=$row['person_name'];
            $job=$row['job'];
            $passport=$row['passport'];
            $nationality=$row['nationality'];
            $labour_card=$row['labour_card'];
            $labour_card_expiry= gmdate("Y-m-d", $unix_date);
            $card_type=$row['card_type'];
            $class=$row['class'];
            $company_no=$row['company_no'];

            $obj = \App\Model\LabourUpload::find($data_partnumber);

            $obj->person_code=$person_code;
            $obj->person_name=$person_name;
            $obj->job=$job;
            $obj->passport=$passport;
            $obj->nationality=trim($nationality);
            $obj->labour_card=$labour_card;
            $obj->labour_card_expiry=$labour_card_expiry;
            $obj->card_type=$card_type;
            $obj->class=$class;
            $obj->company_no=$company_no;

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

        $trans_id = DB::table('labour_uploads')->where('person_code', $person_code)->first();

        return optional($trans_id)->id;
    }

    public function checkExistData($person_code){

        $query=\App\Model\LabourUpload::where('id', $person_code)->get()->first();

        $trans_id= isset($query->id)?$query->id:"";
        return $trans_id;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }
}
