<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Model\Passport\Passport;
use App\Model\VisaProcess\LabourCard;
use App\Model\VisaProcess\CurrentStatus;
use DB;

class LabourCardImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    use Importable, SkipsErrors;
    public function model(array $row){
        //
        $pp_uid = $row['pp_uid'];
        $passport = Passport ::where('pp_uid','=',$pp_uid)->first();



        if($passport != null){

            $excel_date = $row['labour_card_expiry']; //here is that value 41621 or 41631
            $unix_date = ($excel_date - 25569) * 86400;
            $excel_date = 25569 + ($unix_date / 86400);
            $unix_date = ($excel_date - 25569) * 86400;


            $current_status= CurrentStatus::where('passport_id',$passport->id)->first();
            $current_status_val=$current_status->current_process_id;

            // dd($current_status_val);

            $passport_id = $passport->id;
            $labour_card_no = $row['labour_card_num'];
            $person_code = $row['14_digits_person_code'];
            $labour_card_expiry = $row['labour_card_expiry'];




            if($current_status_val <= '21'){
                return new LabourCard([
                    'passport_id' => $passport->id,
                    'labour_card_no' => $labour_card_no,
                    'person_code' => $person_code,
                    'labour_card_expiry_date' =>gmdate("Y-m-d", $unix_date),

                ]);
            }elseif($current_status_val>'21'){

                DB::table('labour_cards')->where('passport_id', $passport->id)->update([
                    'labour_card_no' => $labour_card_no,
                    'person_code' => $person_code,
                    'labour_card_expiry_date' => gmdate("Y-m-d", $unix_date),]);



            }
            else{
                return null;
            }




        }else{
            return  null;
        }
    }
}
