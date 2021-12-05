<?php

namespace App\Model\VisaProcess;

use App\Model\Master_steps;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\VisaProcess\RenewVisaSteps;
use App\Model\VisaProcess\RenewAgreedAmount;

class AssigningAmount extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //



    public $table = "assigning_amounts";
    protected $fillable = ['amount', 'master_step_id','passport_id','agreement_id','agreed_amount_id','pay_at','partial_amount_step','rn_visa_process_status','rn_step_id','rn_pay_status'];

    public function master()
    {
        return $this->belongsTo(Master_steps::class,'master_step_id');
    }
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function pay_later()
    {
        return $this->belongsTo(Master_steps::class,'pay_at');
    }

    public function partial_amount_to_be()
    {
        return $this->belongsTo(Master_steps::class,'partial_amount_step');
    }
    public function master_renew()
    {
        return $this->belongsTo(RenewVisaSteps::class,'rn_step_id');
    }
}
