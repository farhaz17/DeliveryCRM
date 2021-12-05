<?php

namespace App\Model\BikesTracking;


use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Master\Vehicle\VehicleTrackingInventory;

class BikesTracking extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function bike()
    {
        return $this->belongsTo(BikeDetail::class,'bike_id');
    }

    public function tracker()
    {
        return $this->belongsTo(VehicleTrackingInventory::class, 'tracking_number');
    }
    public function previous_tracker()
    {
        return $this->belongsTo(VehicleTrackingInventory::class, 'new_shuffled_tracker_id');
    }
}