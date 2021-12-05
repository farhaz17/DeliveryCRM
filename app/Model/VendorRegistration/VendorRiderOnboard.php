<?php

namespace App\Model\VendorRegistration;
use App\Model\Nationality;
use App\Model\Master\FourPl;
use App\Model\Assign\AssignSim;
use App\Model\Assign\AssignBike;
use App\Model\Passport\Passport;
use App\Model\Assign\AssignPlateform;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\CreateInterviews\CreateInterviews;

class VendorRiderOnboard extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    public function nation()
    {
        return $this->belongsTo(Nationality::class,'nationality');
    }

    public function platform()
    {
        return $this->hasMany(AssignPlateform::class, 'passport_id');
    }

    public function platform_report()
    {
        return $this->hasMany(AssignPlateform::class, 'passport_id', 'passport_id');
    }

    public function assign_platform_check(){
        return $this->platform_report()->where('status','=','1')->first();
    }

    public  function bike_assign(){
        return $this->hasMany(AssignBike::class,'passport_id','passport_d');
    }

    public function assign_bike_check(){
        return $this->bike_assign()->where('status','=','1')->first();
    }

    public function sim_assign(){
        return $this->hasMany(AssignSim::class,'passport_id','passport_id');
    }

    public function assign_sim_check(){
        return $this->sim_assign()->where('status','=','1')->first();
    }

    public function vendor()
    {
        return $this->belongsTo(FourPl::class, 'four_pls_id');
    }

    public function interview()
    {
        return $this->hasOne(CreateInterviews::class, 'career_id', 'career_id')->orderBy('id', 'DESC');
    }

    public function onboard()
    {
        return $this->hasOne(OnBoardStatus::class, 'career_id', 'career_id')->orderBy('id', 'DESC');
    }

    public function passport_detail(){
        return $this->hasone(Passport::class,'passport_no','passport_no');
    }
}
