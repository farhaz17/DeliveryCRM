<?php

namespace App\Imports;

use App\Model\Passport\Ppuid;
use App\Model\Telecome;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ppuidImport implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $sim_number_array=trim($row['sim_number']);
        $firstChar = mb_substr($sim_number_array, 0, 1, "UTF-8");
        $zero='0';
        if ($sim_number_array=="-"){
            $sim="";

        }
        else if ($firstChar !='0') {
            $sim = substr_replace($sim_number_array, $zero, 0, 0);
        }
        else{
            $sim= $sim_number_array=trim($row['sim_number']);
        }



        $data_partnumber=$this->checkExistData($this->getPartNumberId(trim($row['passport_id'])));
        if($data_partnumber == ""){

            $passport_id_array=$row['passport_id'];
            $ppuid_id_array=$row['ppuid'];
            $zds_code_array=$row['zds_code'];
            $passport_number_array=$row['passport_number'];
            $rider_name_array=$row['rider_name'];
            $platform_array=$row['platform'];
            $sim_number_array=$sim;
            $bike_number_array=$row['bike_number'];
            $visa_status_array=$row['visa_status'];
            $control_status_array=$row['control_status'];
            $msp_status_array=$row['msp_status'];
            $platform_rider_id_array=$row['platform_rider_id'];

            return new Ppuid([
                'passport_id'  => trim($passport_id_array),
                'ppuid'  => trim($ppuid_id_array),
                'zds_code'  => trim($zds_code_array),
                'passport_number'  => trim($passport_number_array),
                'rider_name'  => trim($rider_name_array),
                'platform'  => trim($platform_array),
                'sim_number'  => trim($sim_number_array),
                'bike_number'  => trim($bike_number_array),
                'visa_status'  => trim($visa_status_array),
                'control_status'  => trim($control_status_array),
                'msp_status'  => trim($msp_status_array),
                'platform_rider_id'  => trim($platform_rider_id_array),
            ]);


        }
        else{




            $passport_id=$row['passport_id'];
            $ppuid_id=$row['ppuid'];
            $zds_code=$row['zds_code'];
            $passport_number=$row['passport_number'];
            $rider_name=$row['rider_name'];
            $platform=$row['platform'];
            $sim_number=$sim;
            $bike_number=$row['bike_number'];
            $visa_status=$row['visa_status'];
            $control_status=$row['control_status'];
            $msp_status=$row['msp_status'];
            $platform_rider_id=$row['platform_rider_id'];


            $obj = Ppuid::find($data_partnumber);
            $obj->passport_id = trim($passport_id);
            $obj->ppuid=  trim($ppuid_id);
            $obj->zds_code =  trim($zds_code);
            $obj->passport_number =  trim($passport_number);
            $obj->rider_name =  trim($rider_name);
            $obj->platform =  trim($platform);
            $obj->sim_number =  trim($sim_number);
            $obj->bike_number =  trim($bike_number);
            $obj->visa_status = trim($visa_status);
            $obj->control_status =  trim($control_status);
            $obj->msp_status =  trim($msp_status);
            $obj->platform_rider_id =  trim($platform_rider_id);
            $obj->save();
        }
    }

    public function getPartNumberId($passport_id){

        $pass_id = DB::table('ppuids')->where('passport_id', $passport_id)->first();

        return optional($pass_id)->id;
    }

    public function checkExistData($passport_id){

        $query=Ppuid::where('id', $passport_id)->get()->first();

        $account_id= isset($query->id)?$query->id:"";
        return $account_id;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }
}
