<?php

namespace App\Model\BikeReplacement;

use App\Model\Platform;
use App\Model\BikeDetail;
use App\Model\Assign\AssignBike;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BikeReplacement extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function temporary_plate_number()
    {
        return $this->belongsTo(BikeDetail::class,'new_bike_id');
    }

    public function temporary_bike()
    {
        return $this->belongsTo(BikeDetail::class,'new_bike_id');
    }

    public function permanent_bike()
    {
        return $this->belongsTo(BikeDetail::class,'replace_bike_id');
    }

    public function permanent_plate_number()
    {
        return $this->belongsTo(BikeDetail::class,'replace_bike_id');
    }

    public function goto_assign_detail()
    {
        return $this->belongsTo(AssignBike::class,'assign_bike_id','id');
    }

    public function plateformdetail()
    {
        return $this->belongsTo(Platform::class,'plateform');
    }
}
