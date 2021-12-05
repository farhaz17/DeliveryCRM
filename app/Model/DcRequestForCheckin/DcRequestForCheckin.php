<?php

namespace App\Model\DcRequestForCheckin;

use App\User;
use App\Model\Cities;
use App\Model\Platform;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Riders\DefaulterRiders\DefaulterRider;

class DcRequestForCheckin extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function rider_name(){
        return $this->belongsTo(Passport::class,'rider_passport_id','id');
    }

    public function platform(){
        return $this->belongsTo(Platform::class,'platform_id','id');
    }

    public function request_by(){
        return $this->belongsTo(User::class,'request_by_id','id');
    }

    public function city(){
        return $this->belongsTo(Cities::class,'city_id','id');
    }

    public function request_approved_by(){
        return $this->belongsTo(User::class,'approve_by_id','id');
    }

    public function defaulter_rider_details(){
        return  $this->hasMany(DefaulterRider::class,'passport_id','rider_passport_id');
    }
}
