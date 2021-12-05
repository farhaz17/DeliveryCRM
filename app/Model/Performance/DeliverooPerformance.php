<?php

namespace App\Model\Performance;

use App\Model\Passport\Passport;
use App\Model\UserCodes\UserCodes;
use App\Model\Assign\AssignPlateform;
use Illuminate\Database\Eloquent\Model;
use App\Model\PlatformCode\PlatformCode;
use OwenIt\Auditing\Contracts\Auditable;

class DeliverooPerformance extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "deliveroo_performances";
    protected $fillable=['rider_id',
        'rider_name',
        'hours_scheduled',
        'hours_worked',
        'attendance',
        'no_of_orders_delivered',
        'no_of_orders_unassignedr',
        'unassigned',
        'wait_time_at_customer',
        'date_from',
        'date_to',
        'status'
    ];



    public function platform_code()
    {
        return $this->hasOne(PlatformCode::class,'platform_code','rider_id');
    }

    public function platform_codes(){
        return $this->hasMany(PlatformCode::class, 'platform_code', 'rider_id');
    }

    public function rider_platform()
    {
        return $this->hasOne(AssignPlateform::class,'platform_code','rider_id');
    }
    public function get_the_rider_id_by_platform($platform_id)
    {
        return $this->platform_codes()->where('platform_id','=',$platform_id)->with('passport')->first();
    }



//    public function platform_codes(){
//        return $this->hasMany(PlatformCode::class, 'passport_id', 'id');
//    }
//


}


