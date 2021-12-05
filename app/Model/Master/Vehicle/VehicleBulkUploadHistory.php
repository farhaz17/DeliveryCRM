<?php

namespace App\Model\Master\Vehicle;

use App\User;
use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VehicleBulkUploadHistory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function get_uploaded_vehicles(){
        return BikeDetail::whereIn('id', json_decode($this->vehicle_ids))->get();
    }
}
