<?php

namespace App\Imports;

use App\Model\ArBalance\ArBalance;
use App\Model\ArBalance\ArBalanceAlready;
use App\Model\ArBalance\ArBalanceNotAvailable;
use App\Model\ArBalance\ArBalanceSheet;
use App\Model\Fines;
use App\Model\Passport\Passport;
use App\Model\UserCodes\UserCodes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ArBalanceImport implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
//        $data_partnumber = $this->checkExistData($this->getPartNumberId(trim($row['zds_code'])));
//
//        if ($data_partnumber == "") {
            $pp_uid = $row['pp_uid'];
        $passport = Passport::where('pp_uid','=',$pp_uid)->first();


        if($passport != null){

            
            $rider_id_array = $row['rider_id'];
            $name_array = $row['name'];
            $agreed_amount_array = $row['agreed_amount'];
            $cash_received_array = $row['cash_received'];
            $discount_array = $row['discount'];
            $deduction_array = $row['deduction'];
            $balance_array = $row['balance'];
            return new ArBalance([
                'passport_id' => $passport->id,
                'rider_id' => $rider_id_array,
                'name' => $name_array,
                'agreed_amount' => $agreed_amount_array,
                'cash_received' => $cash_received_array,
                'discount' => $discount_array,
                'deduction' => $deduction_array,
                'balance' => $balance_array,
            ]);
        }else{
            return  null;
        }



    }
}
//
//        } else {
//            $zds_code_array = $row['zds_code'];
//            $rider_id_array = $row['rider_id'];
//            $name_array = $row['name'];
//            $agreed_amount_array = $row['agreed_amount'];
//            $cash_received_array = $row['cash_received'];
//            $discount_array = $row['discount'];
//            $deduction_array = $row['deduction'];
//            $balance_array = $row['balance'];
//            $this->getPartNumberId2($zds_code_array, $rider_id_array, $name_array, $agreed_amount_array,
//                $cash_received_array, $discount_array, $deduction_array, $balance_array);
//
//        }
//    }
//
//
//    public function getPartNumberId($zds_code_array)
//    {
//        $trans_id = DB::table('ar_balances')->where('zds_code', $zds_code_array)->first();
//        return optional($trans_id)->id;
//    }
//
//    public function checkExistData($zds_code_array)
//    {
//        $query = ArBalance::where('id', $zds_code_array)->get()->first();
//        $trans_id = isset($query->id) ? $query->id : "";
//        return $trans_id;
//    }
//
//    public function getPartNumberId2($zds_code_array, $rider_id_array, $name_array, $agreed_amount_array, $cash_received_array, $discount_array, $deduction_array, $balance_array)
//    {
//        $data_partnumber = $this->checkExistData($this->getPartNumberId(trim($zds_code_array)));
//
//        if ($data_partnumber != "") {
//            $gamer = new ArBalanceAlready();
//            $gamer->zds_code =$zds_code_array;
//            $gamer->rider_id= $rider_id_array;
//            $gamer->name = $name_array;
//            $gamer->agreed_amount = $agreed_amount_array;
//            $gamer->cash_received = $cash_received_array;
//            $gamer->discount = $discount_array;
//            $gamer->deduction = $deduction_array;
//            $gamer->balance = $balance_array;
//            $gamer->save();
//            //---------update ar_balance table with detucting amount
//            return true;
//        }




