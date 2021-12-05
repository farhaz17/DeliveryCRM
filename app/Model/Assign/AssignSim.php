<?php

namespace App\Model\Assign;


use App\Model\Platform;
use App\Model\Telecome;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AssignSim extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $table = "assign_sims";

    protected $fillable=['passport_id','sim','assigned_to','checkin', 'checkout','remarks','status','verified','rider_type'];

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function telecome()
    {
        return $this->belongsTo(Telecome::class,'sim');
    }

    public function assign_to()
    {
        return $this->belongsTo(SimAssignType::class,'assigned_to','id');
    }


    public function plateform()
    {

        return $this->hasMany(AssignPlateform::class,'passport_id','passport_id');
    }

    public function assign_plateform()
    {
        return $this->plateform()->where('status','=','1')->first();
    }

    public function plateformdetail()
    {
        return $this->belongsTo(Platform::class,'plateform');
    }

    public function telecomes()
    {
        return $this->belongsTo(Telecome::class,'assignsim');
    }

}
