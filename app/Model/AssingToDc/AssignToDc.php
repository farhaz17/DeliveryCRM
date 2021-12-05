<?php

namespace App\Model\AssingToDc;

use App\User;
use App\Model\Platform;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AssignToDc extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['rider_passport_id','platform_id','user_id','checkin','checkout','status'];
    public function passport()
    {
        return $this->belongsTo(Passport::class,'rider_passport_id');
    }

    public function user_detail()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class,'platform_id');
    }

    public function getCheckinAttribute($checkin) {
        return date("Y-m-d", strtotime($checkin));
    }

    public function getCheckoutAttribute($checkout) {
        return date("Y-m-d", strtotime($checkout));
    }
}
