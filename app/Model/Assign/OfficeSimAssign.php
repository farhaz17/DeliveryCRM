<?php

namespace App\Model\Assign;

use App\Model\Telecome;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OfficeSimAssign extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function assign_to()
    {
        return $this->belongsTo(SimAssignType::class,'assigned_to','id');
    }

    public function telecome()
    {
        return $this->belongsTo(Telecome::class,'sim_id');
    }

    public function plateform()
    {

        return $this->hasMany(AssignPlateform::class,'passport_id','passport_id');
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
}
