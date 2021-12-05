<?php

namespace App\Model;

use App\User;
use App\Model\Passport\Passport;
use App\Model\Assign\AssignPlateform;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\DcRequestForCheckin\DcRequestForCheckin;

class RiderHoldDC extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $table = 'rider_holds_for_dc';
    public function assign_platform(){
        return $this->belongsTo(AssignPlateform::class,'assign_platform_id');
    }

    public function parent_category()
    {
        return $this->belongsTo(RiderHoldDC::class, 'rejected_primary_id');
    }

    public function children()
    {
        return $this->hasMany(RiderHoldDC::class, 'rejected_primary_id');
    }

    public function children_total_count()
    {
        return $this->children()->count();
    }
    public function get_the_latest_child(){

        return $this->children()->orderby('id','desc')->first();
    }

    public function checkin_assign_platform(){
        return $this->assign_platform()->where('status','=','1')->first();
    }

    public function check_in_request(){
        return  $this->belongsTo(DcRequestForCheckin::class,'dc_request_for_checkin_id');
    }

    public function dc_detail(){
        return $this->belongsTo(User::class,'dc_id','id');
    }

}
