<?php

namespace App\Model\BikeAssignPlatform;

use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class bike_assing_platforms extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    function bike_detail(){
        return $this->belongsTo(BikeDetail::class,'bike_id');
    }

}
