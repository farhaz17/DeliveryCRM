<?php

namespace App\Imports;

use App\Model\Assign\AssignPlateform;
use App\Model\AssingToDc\AssignToDc;
use App\Model\UserCodes\UserCodes;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssignToDCImport implements  ToModel ,WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    use Importable, SkipsErrors;


    private  $dc_id = "";
    private  $platform_id = "";

    public function __construct($dc_id,$platform_id)
    {


        $this->dc_id = $dc_id;
        $this->platform_id = $platform_id;

    }

    public function model(array $row)
    {

        $passport_id =  $this->checkZdsCode($row['zds_code']);

        if($passport_id != null && $this->checkPlatformAssign($row['zds_code'],$this->platform_id)){


            return new AssignToDc([
                'rider_passport_id'  =>  $passport_id,
                'platform_id'  => $this->platform_id,
                'user_id'  => $this->dc_id ,
                'status'  => "1"
            ]);

        }else{
            return  null;
        }


    }

    public function checkZdsCode($zds_code){
        $query = UserCodes::where('zds_code', '=', $zds_code)->first();
        $result = isset($query->passport_id)?$query->passport_id:null;
        return  $result;
    }

    public function checkPlatformAssign($zds_code,$platform_id){

        $query = UserCodes::where('zds_code', '=', $zds_code)->first();

        if($query!=null){
            $assign_platform = AssignPlateform::where('passport_id','=',$query->passport_id)->where('plateform','=',$platform_id)->where('status','=','1')->first();

                if($assign_platform==null){
                    return false;
                }else{
                    $dc_assign = AssignToDc::where('rider_passport_id','=',$query->passport_id)->where('status','=','1')->first();

                    if($dc_assign!=null){
                        return false;
                    }else{
                        return true;
                    }
                }
        }else{
            return false;
        }



    }


}
