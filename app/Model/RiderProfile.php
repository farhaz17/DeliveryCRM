<?php

namespace App\Model;

use App\User;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RiderProfile extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function passport_ticket()
    {
        return $this->belongsTo(Passport::class,'passport_id')->select(['id', 'passport_no']);
    }

    public function verify_from()
    {
        return $this->hasOne(VerificationForm::class,'user_id','id');
    }

}
