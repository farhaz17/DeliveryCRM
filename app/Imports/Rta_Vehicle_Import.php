<?php

namespace App\Imports;





use App\Model\Rta_Vehicle;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Throwable;

class Rta_Vehicle_Import implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $data_partnumber=$this->checkExistData($this->getPartNumberId(trim($row['chassis_no'])));


        if($data_partnumber == ""){



            $excel_date = $row['expiry_date'];; //here is that value 41621 or 41631
            $unix_date = ($excel_date - 25569) * 86400;
            $excel_date = 25569 + ($unix_date / 86400);
            $unix_date = ($excel_date - 25569) * 86400;

            $excel_date2 = $row['issue_date'];; //here is that value 41621 or 41631
            $unix_date2 = ($excel_date2 - 25569) * 86400;
            $excel_date2 = 25569 + ($unix_date2 / 86400);
            $unix_date2 = ($excel_date2 - 25569) * 86400;

            $mortgaged_by_array=$row['mortgaged_by'];
            $insurance_co_array=$row['insurance_co'];
            $expiry_date_array=$row['expiry_date'];
            $issue_date_array=$row['issue_date'];
            $fines_amount_array=$row['fines_amount'];
            $no_of_fines_array=$row['number_of_fines'];
            $registration_valid_for_days_array=$row['registration_valid_for_days'];
            $make_year_array=$row['make_year'];
            $plate_no_array=trim($row['chassis_no']);
            $chassis_no_array=$row['chassis_no'];
            $model_array=$row['model'];
            $traffic_file_number_array=$row['traffic_file_number'];

            return new Rta_Vehicle([
                'mortgaged_by'  => $mortgaged_by_array,
                'insurance_co'  => $insurance_co_array,
                'expiry_date'  => gmdate("Y-m-d", $unix_date),
                'issue_date'  =>gmdate("Y-m-d", $unix_date2),
                'fines_amount'  => $fines_amount_array,
                'number_of_fines'  => $no_of_fines_array,
                'registration_valid_for_days'  => $registration_valid_for_days_array,
                'make_year'  => $make_year_array,
                'plate_no'  => $plate_no_array,
                'chassis_no'  => $chassis_no_array,
                'model'  => $model_array,
                'traffic_file_number'  => $traffic_file_number_array,
            ]);
        }
        else{

            $excel_date = $row['expiry_date'];; //here is that value 41621 or 41631
            $unix_date = ($excel_date - 25569) * 86400;
            $excel_date = 25569 + ($unix_date / 86400);
            $unix_date = ($excel_date - 25569) * 86400;

            $excel_date2 = $row['issue_date'];; //here is that value 41621 or 41631
            $unix_date2 = ($excel_date2 - 25569) * 86400;
            $excel_date2 = 25569 + ($unix_date2 / 86400);
            $unix_date2 = ($excel_date2 - 25569) * 86400;
            $mortgaged_by=$row['mortgaged_by'];
            $insurance_co=$row['insurance_co'];
            $expiry_date=gmdate("Y-m-d", $unix_date);
            $issue_date=gmdate("Y-m-d", $unix_date2);
            $fines_amount=$row['fines_amount'];
            $no_of_fines=$row['number_of_fines'];
            $registration_valid_for_days=$row['registration_valid_for_days'];
            $make_year=$row['make_year'];
            $plate_no=$row['plate_no'];
            $chassis_no=trim($row['chassis_no']);
            $model=$row['model'];
            $traffic_file_number=$row['traffic_file_number'];

            $obj = Rta_Vehicle::find($data_partnumber);

            $obj->mortgaged_by=$mortgaged_by;
            $obj->insurance_co=$insurance_co;
            $obj->expiry_date=$expiry_date;
            $obj->issue_date=$issue_date;
            $obj->fines_amount=$fines_amount;
            $obj->number_of_fines=$no_of_fines;
            $obj->registration_valid_for_days=$registration_valid_for_days;
            $obj->make_year=$make_year;
            $obj->plate_no=$plate_no;
            $obj->chassis_no=$chassis_no;
            $obj->model=$model;
            $obj->traffic_file_number=$traffic_file_number;
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

    public function getPartNumberId($chassis_no){

        $trans_id = DB::table('rta_vehicles')->where('chassis_no', $chassis_no)->first();

        return optional($trans_id)->id;
    }

    public function checkExistData($chassis_no){

        $query=Rta_Vehicle::where('id', $chassis_no)->get()->first();

        $trans_id= isset($query->id)?$query->id:"";
        return $trans_id;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }

}
