<?php

namespace App\Model\VehicleAccident;

use App\User;
use App\Model\BikeDetail;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;

class VehicleAccident extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bikes()
    {
        return $this->belongsTo(BikeDetail::class,'bike_id');
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class,'rider_passport_id');
    }

}
