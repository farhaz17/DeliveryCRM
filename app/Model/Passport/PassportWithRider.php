<?php

namespace App\Model\Passport;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PassportWithRider extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;

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

    public function getReasonAttribute($value) {
        if($value == 1) {
            return "Emergency";
        }
        elseif($value == 2) {
            return "Annual Leave";
        }
        elseif($value == 3) {
            return "Cancellation";
        }
        elseif($value == 4) {
            return "Accident";
        }
        elseif($value == 5) {
            return "Passport Renewal";
        }
        elseif($value == 6) {
            return "Bank/Other Services";
        }

            return "N/A";
    }

}
