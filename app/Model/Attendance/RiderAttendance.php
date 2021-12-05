<?php

namespace App\Model\Attendance;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RiderAttendance extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function  passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function getCreatedAtAttribute($value) {
        return date("Y-m-d", strtotime($value));
    }

    public function getUpdatedAtAttribute($value) {
        return date("Y-m-d", strtotime($value));
    }
}
