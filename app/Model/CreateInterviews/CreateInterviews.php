<?php

namespace App\Model\CreateInterviews;

use App\Model\Platform;
use App\Model\Guest\Career;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\InterviewBatch\InterviewBatch;
use App\Model\Riders\DefaulterRiders\DefaulterRider;

class CreateInterviews extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function career_detail()
    {
        return $this->belongsTo(Career::class,'career_id','id');
    }

    public function batch_info()
    {
        return $this->belongsTo(InterviewBatch::class,'interviewbatch_id');
    }

    public function platform_detail()
    {
        return $this->belongsTo(Platform::class,'platform_id');
    }

    public function defaulter_rider_details(){
        return  $this->hasMany(DefaulterRider::class,'passport_id','passport_id');
    }




}
