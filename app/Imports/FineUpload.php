<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Model\ArBalance\ArBalanceSheet;
use DateTime;

class FineUpload  implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
 private  $file_no = "";



    public function __construct($file_no)
    {
        $this->file_no = $file_no;

    }


    public function model(array $row)
    {
//        dd($row);

        $trans_id =  $this->checkExistData($row['ticket_number']);
        if($trans_id==""){
                 $date_s = DateTime::createFromFormat('d/m/Y', $row['ticket_date']);

                $date_s =  $date_s->format('Y-m-d');

                $offense = "";
                if(isset($row['offense'])){
                    $offense = $row['offense'];
                }elseif(isset($row['the_terms_of_the_offense'])){
                    $offense = $row['the_terms_of_the_offense'];
                }

                // fine upload in ledger

                $bike=\App\Model\BikeDetail::where('plate_no',$row['plate_number'])->first();

                $new_formate =  $date_s;

                $ab = explode(" ",$row['ticket_time']);

                $time_pay_now = $ab[0].':00'.$ab[1];


                $formate_time = $this->get_twenty_four_formate_time($time_pay_now);

                $fine_date = $new_formate." ".$formate_time;
                $payment_date = strtotime($fine_date);


                $array_ab = array(
                    $payment_date,
                    $bike->id
                );

                $checkin_detail = \App\Model\Assign\AssignBike::where('checkin', '<=',$fine_date)
                    ->where('bike','=',$bike->id)
                    ->first();



                // $checkin_detail=\App\Model\Assign\AssignBike::where('bike',$bike->id)->where('status','1')->first();

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
                    $obj->balance_type = '4';
                    $obj->balance = $row['ticket_fee'];
                    $obj->status = '';
                    $obj->platform_id=$platform_id;
                    $obj->upload_file_sheet_id=$this->file_no;


                    $obj->save();
                }

            return new \App\Model\FineUpload\FineUpload([
                'fine_upload_traffic_code_id'  => $this->file_no,
                'plate_number'  => $row['plate_number'],
                'ticket_number'  => $row['ticket_number'],
                'ticket_date'  => $date_s   ,
                'ticket_time' => $row['ticket_time'],
                'fines_source' =>  $row['fines_source'],
                'ticket_fee' => $row['ticket_fee'],
                'offense' => $offense,
                'plate_cateogry' => $row['plate_category'],
                'plate_code' => $row['plate_code'],
                'license_number' => $row['license_number'],
                'license_from' => $row['license_from'],
            ]);

        }else{
            return  null;
        }


    }

    public function failures()
    {
        return $this->failures;
    }

    public function headingRow()
    {
        return 3;
    }

    public function checkExistData($ticket_number){

        $query=\App\Model\FineUpload\FineUpload::where('ticket_number', '=', $ticket_number)->first();

        $trans_id = isset($query->id)?$query->id:"";

        return $trans_id;

    }
    public function get_twenty_four_formate_time($_a){


        $_a = explode(':',$_a);
        $_time = "";                    //initialised the variable.
        if($_a[0] == 12 && $_a[1] <= 59 && strpos($_a[2],"PM") > -1)
        {
            $_rpl = str_replace("PM","",$_a[2]);
            $_time = $_a[0].":".$_a[1].":".$_rpl;
        }
        elseif($_a[0] < 12 && $_a[1] <= 59 && strpos($_a[2],"PM")>-1)
        {
            $_a[0] += 12;
            $_rpl = str_replace("PM","",$_a[2]);
            $_time = $_a[0].":".$_a[1].":".$_rpl;
        }
        elseif($_a[0] == 12 && $_a[1] <= 59 && strpos($_a[2],"AM" ) >-1)
        {
            $_a[0] = 00;
            $_rpl = str_replace("AM","",$_a[2]);
            $_time = $_a[0].":".$_a[1].":".$_rpl;
        }
        elseif($_a[0] < 12 && $_a[1] <= 59 && strpos( $_a[2],"AM")>-1)
        {
            $_rpl = str_replace("AM","",$_a[2]);
            $_time = $_a[0].":".$_a[1].":".$_rpl;
        }

        return $_time;

    }
}
