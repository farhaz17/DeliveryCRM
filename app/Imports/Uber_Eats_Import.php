<?php

namespace App\Imports;
use App\Model\SalarySheet\UberLimo;
use App\Model\UberEats;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
//use Throwable;

class Uber_Eats_Import implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function  __construct($last_id,$uber_limo_sheet_id)
    {

        $this->last_id = $last_id;
        $this->uber_limo_sheet_id = $uber_limo_sheet_id;

    }
    public function model(array $row)
    {

        $path_saved = $this->last_id;
        $uber_limo_sheet_id = $this->uber_limo_sheet_id;

            $driverUUID_array = $row['driveruuid'];
            $tripUUID_array = trim($row['tripuuid']);
            $firstName_array = $row['firstname'];
            $lastName_array = $row['lastname'];
            $amount_array = $row['amount'];
            $timestamp_array = $row['timestamp'];
            $itemType_array = $row['itemtype'];
            $description_array = $row['description'];
            $disclaimer_array = $row['disclaimer'];

            return new UberLimo([
                'driver_u_uid' => $driverUUID_array,
                'trip_u_uid' => $tripUUID_array,
                'first_name' => $firstName_array,
                'last_name' => $lastName_array,
                'amount' => $amount_array,
                'timestamp' => $timestamp_array,
                'item_type' => $itemType_array,
                'description' => $description_array,
                'disclaimer' => $disclaimer_array,
                'file_path' => $path_saved,
                'sheet_id' => $uber_limo_sheet_id,
            ]);
    }
//        else{
//
////            $quantitySet=$this->getQuantityBalance($data_partnumber);
////            $current_quantity=0;
////            $current_quantity_balance=0;
//
//
//
//
//            $driverUUID=$row['driver_u_uid'];
//            $tripUUID=trim($row['trip_u_uid']);
//            $firstName=$row['first_name'];
//            $lastName=$row['last_name'];
//            $amount=$row['amount'];
//            $timestamp=$row['timestamp'];
//            $itemType=$row['item_type'];
//            $description=$row['description'];
//            $disclaimer=$row['disclaimer'];
//
//            $obj = UberEats::find($data_partnumber);
//
//            $obj->driver_u_uid=$driverUUID;
//            $obj->trip_u_uid=$tripUUID;
//            $obj->first_name=$firstName;
//            $obj->last_name=$lastName;
//            $obj->amount=$amount;
//            $obj->timestamp=$timestamp;
//            $obj->item_type=$itemType;
//            $obj->description=$description;
//            $obj->disclaimer=$disclaimer;
//
////dd($obj);
//
//            $obj->save();
//
////            $message = [
////                'message' => 'Updated Successfully',
////                'alert-type' => 'success'
////
////            ];
////            return redirect()->route('form_upload')->with($message);
//        }


//    }

//    public function getPartNumberId($tripUUID){
//
//        $trans_id = DB::table('uber_eats_payment')->where('trip_u_uid', $tripUUID)->first();
//
//        return optional($trans_id)->id;
//    }
//
//    public function checkExistData($tripUUID){
//
//        $query=UberEats::where('id', $tripUUID)->get()->first();
//
//        $trans_id= isset($query->id)?$query->id:"";
//        return $trans_id;
//    }
//
//
//    public function onError(Throwable $e)
//    {
//        // TODO: Implement onError() method.
//    }

}
