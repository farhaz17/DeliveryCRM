<?php

namespace App\Model\Riders\DefaulterRiders;

use App\User;
use App\Model\Passport\Passport;
use App\Model\AssingToDc\AssignToDc;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Riders\DefaulterRiders\DefaulterRiderComments;

class DefaulterRider extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['user_id','passport_id','status','subject','attachments','defaulter_level','defaulter_details','drcm_id','drc_id','accepted','accepted_by','previous_assign_to_dc_id'];

    public function passport()
    {
        return $this->belongsTo(Passport::class, 'passport_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function acceptor()
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }
    public function drc()
    {
        return $this->belongsTo(User::class, 'drc_id');
    }
    public function drcm()
    {
        return $this->belongsTo(User::class, 'drcm_id');
    }

    public function comments()
    {
        return $this->hasMany(DefaulterRiderComments::class, 'defaulter_rider_id')->latest();
    }
    public function previous_dc()
    {
        return $this->belongsTo(AssignToDc::class, 'previous_assign_to_dc_id');
    }

    public function defaulter_rider_details()
    {
        return $this->hasMany(DefaulterRiderDrcAssign::class,'defaulter_rider_id','id');
    }

    public function check_defaulter_rider()
    {
        return $this->defaulter_rider_details()->where('is_defaulter_now','=','0')->first();
    }



}
