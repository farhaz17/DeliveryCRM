<?php

namespace App\Model\Career;

use App\Model\Passport\Passport;
use App\Model\Career\waitlistfollowup;
use App\Model\Career\selected_followup;
use App\Model\Seeder\Followup_statuses;
use Illuminate\Database\Eloquent\Model;
use App\Model\Career\frontdesk_followup;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\Riders\DefaulterRiders\DefaulterRider;

class RejoinCareer extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

//    protected $casts = [
//        'history_status' => 'int',
//    ];
//
//    function getHistoryStatusAttribute(){
//        return json_decode($this->attributes['history_status'],true);
//    }


    function passport_detail(){
        return $this->belongsTo(Passport::class,'passport_id');
    }

    function follow_status(){
        return $this->belongsTo(Followup_statuses::class,'applicant_status');
    }

    public function interviews()
    {
        return $this->hasMany(CreateInterviews::class,'passport_id','passport_id');
    }

    public function career_history(){
        return $this->hasMany(CareerStatusHistory::class);
    }

    public function on_boards()
    {
        return $this->hasMany(OnBoardStatus::class,'passport_id','passport_id');
    }

    public function training_pass()
    {
        return $this->on_boards()->where('is_training','=','1')->count();
    }

    public function training_fail()
    {
        return $this->on_boards()->where('is_training','>','1')->count();
    }

    public function interview_pass()
    {
        return $this->interviews()->where('interview_status','=','1')->count();
    }

    public function check_interview_or_not()
    {
        return $this->interviews()->where('interview_status','=','0')->first();
    }


    public function interview_failed()
    {
        return $this->interviews()->where('interview_status','=','2')->count();
    }

    public function follow_up_frontdesk(){

        return $this->belongsTo(frontdesk_followup::class,'follow_up_status');
    }

    public function follow_up_name(){

        return $this->belongsTo(waitlistfollowup::class,'follow_up_status');
    }

    public function follow_up_name_selected(){

        return $this->belongsTo(selected_followup::class,'follow_up_status');
    }

    public function defaulter_rider_details(){
        return  $this->hasMany(DefaulterRider::class,'passport_id','passport_id');
    }


}
