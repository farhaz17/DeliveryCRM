<?php

namespace App\Model\BikesTracking;

use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BikesTrackingHistory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function plate_number()
    {
        return $this->belongsTo(BikeDetail::class,'bike_id');
    }
}
