<?php

namespace App\Model\Passport;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Model\Passport\PassportWithRider;
use OwenIt\Auditing\Contracts\Auditable;

class LockerPassportRequest extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $dates = ['return_date'];

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'received_from');
    }

    public function personal_info(){
        return $this->belongsTo(passport_addtional_info::class, 'passport_id', 'passport_id');
    }

    public function with_riders(){
        return $this->hasOne(PassportWithRider::class, 'passport_id', 'passport_id')->orderBy('id', 'DESC');
    }
}
