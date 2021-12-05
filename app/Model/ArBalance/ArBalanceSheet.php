<?php

namespace App\Model\ArBalance;

use App\Model\Platform;
use App\Model\Master_steps;
use App\Model\Passport\Passport;
use App\Model\UserCodes\UserCodes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\VisaProcess\RenewVisaSteps;

class ArBalanceSheet extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "ar_balance_sheets";
    protected $fillable=['zds_code','passport_id','date_saved','balance_type', 'balance','status','platform_id','visa_process_step_id','renew_visa_process_step'];

    // public  function zds_cods(){

    //     return $this->belongsTo(UserCodes::class,'zds_code','zds_code');
    // }

    public  function passport(){

        return $this->belongsTo(Passport::class,'passport_id');
    }

    public  function balance_name(){
        return $this->belongsTo(BalanceType::class,'balance_type');
    }
    public  function platform_name(){
        return $this->belongsTo(Platform::class,'platform_id');
    }
    public  function visa_process_step(){
        return $this->belongsTo(Master_steps::class,'visa_process_step_id');
    }
    public  function renewal_visa_process_step(){
        return $this->belongsTo(RenewVisaSteps::class,'renew_visa_process_step');
    }
}
