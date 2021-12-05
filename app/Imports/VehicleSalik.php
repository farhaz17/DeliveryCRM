<?php

namespace App\Imports;

use DateTime;
use App\Model\BikeDetail;
use App\Model\Vehicle_salik;
use Illuminate\Support\Collection;
use App\Model\VehicleSalikOtherTable;
use App\Model\ArBalance\ArBalanceSheet;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VehicleSalik implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
    private  $acount_number = "";
    private  $last_id = "";




    public function __construct($acount_number,$last_id)
    {
        $this->acount_number = $acount_number;
        $this->last_id = $last_id;

    }

    public function model(array $row)
    {

         $trans_id= $this->checkExistData($row['transaction_id']);
        if($trans_id==""){


            $trip_date =  date("Y-m-d", strtotime(trim($row['trip_date'])));
            $bike=\App\Model\BikeDetail::where('plate_no',$row['plate'])->first();

            if($bike != null){
            $checkin_detail = \App\Model\Assign\AssignBike::where('checkin', '<=',$trip_date)
                ->where('bike','=',$bike->id)
                ->first();

            if($checkin_detail!=null){
                $platform_detail=\App\Model\Assign\AssignPlateform::where('passport_id',$checkin_detail->passport_id)->where('status','1')->first();
                if($platform_detail!=null){
                    $platform_id=$platform_detail;
                }
                else{
                    $platform_id='';
                }
                $obj = new ArBalanceSheet();
                $obj->passport_id =$checkin_detail->passport_id;
                $obj->date_saved = date("Y-m-d");
                $obj->balance_type = '3';
                $obj->balance = $row['amountaed'];
                $obj->status = '';
                $obj->platform_id=$platform_id;
                $obj->platform_id=$platform_id;
                $obj->upload_file_sheet_id=trim($this->last_id);
                $obj->save();
            }
        }


            if(!empty($row['transaction_id']) && !empty($row['trip_date']) &&
                    !empty($row['trip_time']) && !empty($row['transaction_post_date']) &&
                !empty($row['toll_gate']) && !empty($row['direction']) && !empty($row['tag_number'])
                && !empty($row['plate']) ){

                $date_change =  date("Y-m-d", strtotime(trim($row['trip_date'])));

                $bike_id = BikeDetail::where('plate_no',$row['plate'])->first();
                return new Vehicle_salik([
                    'transaction_id'  => $row['transaction_id'],
                    'trip_date'  => $date_change,
                    'trip_time'  => $row['trip_time'],
                    'transaction_post_date'  => $row['transaction_post_date'],
                    'toll_gate' => $row['toll_gate'],
                    'direction' =>  $row['direction'],
                    'tag_number' =>  $row['tag_number'],
                    'plate' => $bike_id->id,
                    'amount' => $row['amountaed'],
                    'account_number' => $this->acount_number,
                    'vehicle_salik_sheet_account_id' => $this->last_id,
                ]);

            }else{
                return  null;
            }


        }else{
            $vehicle_salik = Vehicle_salik::where('transaction_id','=',$row['transaction_id'])->first();



                 $vehicle_salik_other = new  VehicleSalikOtherTable();
                    $vehicle_salik_other->vehicle_salik_id = $vehicle_salik->id;
                    $vehicle_salik_other->amount = $vehicle_salik->amount;
                    $vehicle_salik_other->save();

            $vehicle_salik->amount = $row['amountaed'];
            $vehicle_salik->update();


            return  null;
        }



    }



    public function failures()
    {
        return $this->failures;
    }

    public function headingRow()
    {
        return 15;
    }

    public function checkExistData($transaction_id){

        $query= Vehicle_salik::where('transaction_id', '=', $transaction_id)->first();

        $trans_id = isset($query->id)?$query->id:"";

        return $trans_id;

    }

}
