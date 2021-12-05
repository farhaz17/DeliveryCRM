<?php

namespace App\Model\BikesTracking;

use App\User;
use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TrackerRequest extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bike()
    {
        return $this->belongsTo(BikeDetail::class,'bike_id');
    }
}
