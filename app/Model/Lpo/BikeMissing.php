<?php

namespace App\Model\Lpo;

use App\Model\BikeDetail;
use App\Model\Assign\AssignBike;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BikeMissing extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function bike() {
        return $this->belongsTo(BikeDetail::class);
    }

    public function assign_bike() {
        return $this->belongsTo(AssignBike::class);
    }

}
