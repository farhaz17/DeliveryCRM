<?php

namespace App\Model\VisaProcess;

use App\User;
use App\Model\Master_steps;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaProcessResumeAndStop extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable = ['passport_id', 'visa_process_step_id','remarks','time_and_date','user_id','status'];

    public function master()
    {
        return $this->belongsTo(Master_steps::class,'visa_process_step_id');
    }

    public function passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function user_info(){
        return $this->belongsTo(User::class,'user_id');
    }
}
