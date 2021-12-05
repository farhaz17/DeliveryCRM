<?php

namespace App\Model\VisaProcess;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
// use OwenIt\Auditing\Contracts\Auditable;

class RenewAgreedAmount extends Model
{
    // use \OwenIt\Auditing\Auditable;
    //
    public $table = "renew_agreed_amounts";
    protected $fillable = ['passport_id','agreed_amount','discount_id','discount_amount','advance_amount','final_amount','payroll_deduction','current_status'];


    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function renew_visa_step(){
        return $this->belongsTo(RenewVisaSteps::class,'current_status');
    }
}

