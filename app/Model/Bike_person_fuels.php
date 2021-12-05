<?php

namespace App\Model;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\BikeReplacement\BikeReplacement;

class Bike_person_fuels extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public function passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function bike_detail(){
        return $this->belongsTo(BikeDetail::class,'bike_id');
    }

    public function bike_replacement(){
        return $this->belongsTo(BikeReplacement::class,'bike_id','new_bike_id')->where('status','=','1');
    }
}
