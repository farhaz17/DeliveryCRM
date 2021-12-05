<?php

namespace App\Model\Package;

use Illuminate\Database\Eloquent\Model;
use App\Model\Passport\Passport;
use App\Model\Package\Package;

class PackageAssignment extends Model
{
    //
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class,'package_id');
    }
}
