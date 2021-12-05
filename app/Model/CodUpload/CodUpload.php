<?php

namespace App\Model\CodUpload;

use App\Model\Platform;
use App\Model\Cods\Cods;
use App\Model\RiderProfile;
use App\Model\Cods\CloseMonth;
use App\Model\Passport\Passport;
use App\Model\Cods\DeliverooFollowUp;
use Illuminate\Database\Eloquent\Model;
use App\Model\PlatformCode\PlatformCode;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\CodAdjustRequest\CodAdjustRequest;

class CodUpload extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['start_date',
                        'end_date',
                        'rider_id',
                       'amount',
                       'platform_id','passport_id'];

    public function platform()
    {
        return $this->belongsTo(Platform::class,'platform_id','id');
    }
    public function rider_code(){
        return  $this->belongsTo(PlatformCode::class,'rider_id','platform_code');
    }
    public function  passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function follow_ups()
    {
        return $this->hasMany(DeliverooFollowUp::class, 'cod_upload_id');
    }
    public function close_month(){

        return $this->hasOne(CloseMonth::class,'passport_id','passport_id')->selectRaw('passport_id, sum(close_month_amount) as close_total')->groupBy('passport_id');
    }
    public function cods(){

        return $this->hasOne(Cods::class,'passport_id','passport_id')->selectRaw('passport_id, sum(amount) as cod_total')->where('status','1')->groupBy('passport_id');
    }
    public function codadjust(){

        return $this->hasOne(CodAdjustRequest::class,'passport_id','passport_id')->selectRaw('passport_id, sum(amount) as adj_req_total')->where('status','=','2')->groupBy('passport_id');
    }
    public function  rider_profile(){
        return $this->belongsTo(RiderProfile::class,'passport_id','passport_id')->select(['id','passport_id','contact_no']);
    }

}
