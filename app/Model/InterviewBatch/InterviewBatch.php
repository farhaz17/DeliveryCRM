<?php

namespace App\Model\InterviewBatch;

use App\Model\Platform;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\CreateInterviews\CreateInterviews;

class InterviewBatch extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $casts = [
        'cities' => 'int',
    ];

    function getCitiesAttribute(){
        return json_decode($this->attributes['cities'],true);
    }

    //
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public  function interviews(){
        return $this->hasMany(CreateInterviews::class,'interviewbatch_id');
    }

    public function pass_interviews() {

        return $this->interviews()->where('interview_status','=', '1');
    }


}
