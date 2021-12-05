<?php

namespace App\Model\DrivingLicenseStatuses;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Seeder\DrivingLicenseSteps;

class DrivingLicenseStatuses extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];


    public function passport_detail()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function step_detail()
    {
        return $this->belongsTo(DrivingLicenseSteps::class,'driving_license_step_id');
    }



}
