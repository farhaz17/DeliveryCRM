<?php

namespace App\Imports;



use Throwable;

use App\Model\FcmToken;
use App\Model\Notification;
use App\Model\RiderProfile;
use App\Model\CodUpload\CodUpload;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Model\CodUpload\DuplicateCod;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithProgressBar;


class CodUploads implements ToModel,WithStartRow
{
    use Importable, SkipsErrors;



    /**
     * CodUploads constructor.
     */
    private  $platform_id;
    private  $start_date;
    private  $end_date;

    public function __construct($platform_id,$start_date,$end_date)
    {
        $this->platform_id = $platform_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */



    public function model(array $row)
    {

//        $data_partnumber=$this->checkExistData($this->getPartNumberId(trim($row['ticket_number'])));

//        $excel_date = $row['order_date'];; //here is that value 41621 or 41631
//
//        $unix_date = ($excel_date - 25569) * 86400;
//        $excel_date = 25569 + ($unix_date / 86400);
//        $unix_date = ($excel_date - 25569) * 86400;]


        if(empty($row[0]) || $row[1]=="0" ||  $row[1]==null || $row[1]=="-"){

            return null;
        }


            $rider_id=$row[0];
            $amount=trim($row[1]);

             $pass = PlatformCode::where('platform_code','=',$rider_id)->first();

        // $notification_msg = "You got new Cod, amount=".$amount;

        // if($pass != null){
        //     $obj2 = RiderProfile::where('passport_id','=',$pass->passport_id)->first();
        //     if(!empty($obj2)){
        //         $token=FcmToken::select('fcm_token')->where('user_id', '=', $obj2->user_id)->first();
        //         if(!empty($token)){
        //             $token  = $token->fcm_token;
        //             $title = $notification_msg;
        //             $body = "";
        //             $activity="CODACTIVITY";
        //             $notification = new Notification;
        //             $notification->singleDevice($token,$title,$body,$activity);
        //         }
        //     }
        // }



//             $pass = PlatformCode::where('platform_code','=',$rider_id)->first();
//
//        $notification_msg = "You got new Cod, amount=".$amount;
//
//        if($pass != null){
//            $obj2 = RiderProfile::where('passport_id','=',$pass->passport_id)->first();
//            if(!empty($obj2)){
//                $token=FcmToken::select('fcm_token')->where('user_id', '=', $obj2->user_id)->first();
//                if(!empty($token)){
//                    $token  = $token->fcm_token;
//                    $title = $notification_msg;
//                    $body = "";
//                    $activity="CODACTIVITY";
//                    $notification = new Notification;
//                    $notification->singleDevice($token,$title,$body,$activity);
//                }
//            }
//        }
// if(!$pass) return;
      return new CodUpload([
                'rider_id'  => $rider_id,
                'amount'  => $amount,
                'platform_id'  => $this->platform_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'passport_id' => $pass->passport->id,

            ]);

    }



    /**
     * @param Failure[] $failures
     */
//    public function onFailure(SkipsFailures $failures)
//    {
//        // Handle the failures how you'd like.
//    }

    public function failures()
    {
        return $this->failures;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }
    public function startRow(): int
    {
        return 2;
    }

}
