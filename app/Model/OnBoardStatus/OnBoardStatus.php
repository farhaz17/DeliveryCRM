<?php

namespace App\Model\OnBoardStatus;

use App\Model\Guest\Career;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\Riders\DefaulterRiders\DefaulterRider;

class OnBoardStatus extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    public $table = "on_boarding_statuses";
    protected $fillable = ['passport_id', 'driving_license_status',
        'living_status','passport_handler_status','career_id','platform_assign','is_training'];


    public function passport_detail(){
        return $this->belongsTo(Passport::class,'passport_id','id');
    }

    public function career_detail(){
        return $this->belongsTo(Career::class,'career_id','id');
    }






    public function career_batch_detail(){
        return $this->belongsTo(CreateInterviews::class,'create_interview_id','id')->orderBy('id','desc');
    }

    public function on_board_status_type_detail(){

        return $this->belongsTo(OnBoardStatusType::class,'passport_id','passport_id')->where('applicant_status','=','1');
    }

    public function defaulter_rider_details(){
        return  $this->hasMany(DefaulterRider::class,'passport_id','passport_id');
    }




}
