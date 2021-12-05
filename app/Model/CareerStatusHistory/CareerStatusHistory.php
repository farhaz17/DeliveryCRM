<?php

namespace App\Model\CareerStatusHistory;

use App\User;
use App\Model\Guest\Career;
use App\Model\Passport\Passport;
use App\Model\Career\RejoinCareer;
use App\Model\shortlisted_statuses;
use App\Model\Career\waitlistfollowup;
use App\Model\Seeder\Followup_statuses;
use Illuminate\Database\Eloquent\Model;
use App\Model\Career\frontdesk_followup;
use OwenIt\Auditing\Contracts\Auditable;

class CareerStatusHistory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "career_status_histories";
    protected $fillable = [
        'career_id',
        'status',
        'user_id',
        'remarks',
        'status_after_shortlist'
    ];


    public function career(){
        return $this->belongsTo(Career::class,'career_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function rejoin_career(){
        return $this->belongsTo(RejoinCareer::class,'passport_id');
    }

    public function follow_status(){
        return $this->belongsTo(Followup_statuses::class,'status','id');
    }

    public function status_after_shortlist_detail(){
        return $this->belongsTo(shortlisted_statuses::class,'status','id');
    }

    function passport_detail(){
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function follow_up_frontdesk(){

        return $this->belongsTo(frontdesk_followup::class,'follow_up_status');
    }

    public function follow_up_name(){

        return $this->belongsTo(waitlistfollowup::class,'follow_up_status');
    }



}
