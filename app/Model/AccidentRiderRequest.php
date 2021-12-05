<?php

namespace App\Model;

use App\User;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AccidentRiderRequest extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public function rider_name(){
        return $this->belongsTo(Passport::class,'rider_passport_id','id');
    }

    public function requested_by(){
        return $this->belongsTo(User::class,'dc_id','id');
    }

    public function accepted_by(){
        return $this->belongsTo(User::class,'team_leader_id','id');
    }

    public function bike(){
        return $this->belongsTo(BikeDetail::class, 'bike_id');
    }

}
