<?php

namespace App\Model;

use App\Bike;
use App\User;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManageRepair extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable ,SoftDeletes;
    public function bike()
    {
        return $this->belongsTo(BikeDetail::class,'bike_id');
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class,'rider_passport_id');
    }

    public function repairParts(){
        return $this->hasMany(RepairUsedParts::class, 'repair_job_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'advised_by');
    }
}
