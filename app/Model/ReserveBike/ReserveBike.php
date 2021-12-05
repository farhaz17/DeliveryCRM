<?php

namespace App\Model\ReserveBike;

use App\Model\Telecome;
use App\Model\BikeDetail;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ReserveBike extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function reserve_bike(){
        return $this->belongsTo(BikeDetail::class,'bike_id','id');
    }

    public function reserve_sim(){
        return $this->belongsTo(Telecome::class,'sim_id','id');
    }
}
