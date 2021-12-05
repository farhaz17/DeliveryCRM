<?php

namespace App\Model\Assign;

use App\User;
use App\Model\Platform;
use App\Model\BikeDetail;
use App\Model\BikeDetailHistory;
use App\Model\Passport\Passport;
use App\Model\UserCodes\UserCodes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AssignBike extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $table = "assign_bikes";
    protected $fillable=['passport_id','bike','checkin','checkout', 'remarks','verified','checkout_reason','rider_type'];
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function bike_plate_number()
    {
        return $this->belongsTo(BikeDetail::class,'bike');
    }
    public function plateform()
    {
        return $this->hasMany(AssignPlateform::class,'passport_id','passport_id');
    }

    public function plateformdetail()
    {
        return $this->belongsTo(Platform::class,'plateform');
    }
    public function plateforms()
    {
        return $this->hasOne(AssignPlateform::class,'passport_id','passport_id')->where('status','=', 1);
    }
}
