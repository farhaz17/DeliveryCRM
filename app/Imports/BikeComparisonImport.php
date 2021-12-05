<?php

namespace App\Imports;

use App\Model\BikeDetail;
use App\Model\BikeImports;
use App\Model\Telecome;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class BikeComparisonImport implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $data_partnumber=$this->checkExistData($this->getPartNumberId(trim(trim($row['chassis_no']))));
        if($data_partnumber == ""){


            $excel_date = $row['expiry_date'];; //here is that value 41621 or 41631
            $unix_date = ($excel_date - 25569) * 86400;
            $excel_date = 25569 + ($unix_date / 86400);
            $unix_date = ($excel_date - 25569) * 86400;

            $excel_date = $row['issue_date'];; //here is that value 41621 or 41631
            $unix_date = ($excel_date - 25569) * 86400;
            $excel_date = 25569 + ($unix_date / 86400);
            $unix_date2 = ($excel_date - 25569) * 86400;




            $plate_no_array=trim($row['plate_no']);
            $plate_code_array=trim($row['plate_code']);
            $modelarray=$row['model'];
            $make_year_array=$row['make_year'];
            $chassis_no_array=trim($row['chassis_no']);
            $mortgaged_by_array=$row['mortgaged_by'];
            $insurance_co_array=trim($row['insurance_co']);
            $expiry_date_array=$unix_date;
            $issue_date_array=$unix_date2;
            $traffic_file_array=trim($row['traffic_file']);
//          dd($unix_date);

            return new BikeImports([
                'plate_no'  => $plate_no_array,
                'plate_code'  => $plate_code_array,
                'model'  => $modelarray,
                'make_year'  => $make_year_array,
                'chassis_no'  =>$chassis_no_array,
                'mortgaged_by'  => $mortgaged_by_array,
                'insurance_co'  =>$insurance_co_array,
                'expiry_date'  => gmdate("Y-m-d", $unix_date),
                'issue_date'  => gmdate("Y-m-d", $unix_date2),
                'traffic_file'  => $traffic_file_array,

            ]);
        }
        else{

            $excel_date = $row['expiry_date'];; //here is that value 41621 or 41631
            $unix_date = ($excel_date - 25569) * 86400;
            $excel_date = 25569 + ($unix_date / 86400);
            $unix_date = ($excel_date - 25569) * 86400;

            $excel_date = $row['issue_date'];; //here is that value 41621 or 41631
            $unix_date = ($excel_date - 25569) * 86400;
            $excel_date = 25569 + ($unix_date / 86400);
            $unix_date2 = ($excel_date - 25569) * 86400;

            $plate_no=trim($row['plate_no']);
            $plate_code=trim($row['plate_code']);
            $model=$row['model'];
            $make_year=$row['make_year'];
            $chassis_no=$row['chassis_no'];
            $mortgaged_by=$row['mortgaged_by'];
            $insurance_co=trim($row['insurance_co']);
            $expiry_date=$unix_date;
            $issue_date=$unix_date2;
            $traffic_file=$row['traffic_file'];

            $obj = BikeImports::find($data_partnumber);

            $obj->plate_no=  $plate_no;
            $obj->plate_code=$plate_code;
            $obj->model=$model;
            $obj->make_year=$make_year;
            $obj->chassis_no= $chassis_no;
            $obj->mortgaged_by=$mortgaged_by;
            $obj->insurance_co= $insurance_co;
            $obj->expiry_date=gmdate("Y-m-d", $unix_date);
            $obj->issue_date=gmdate("Y-m-d", $unix_date2);
            $obj->traffic_file= $traffic_file;


//dd($obj);

            $obj->save();


        }


    }

    public function getPartNumberId($chassis_no){

        $chasis_id = DB::table('bike_imports')->where('chassis_no', $chassis_no)->first();

        return optional($chasis_id)->id;
    }

    public function checkExistData($chassis_no){

        $query=BikeDetail::where('id', $chassis_no)->get()->first();

        $chasis_id= isset($query->id)?$query->id:"";
        return $chasis_id;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }
}
