<?php

namespace App\Model\DrivingLicense;

use App\Model\Cities;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrivingLicense extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    public $table = "driving_licenses";
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function city()
    {
        return $this->belongsTo(Cities::class, 'place_issue');
    }
}
