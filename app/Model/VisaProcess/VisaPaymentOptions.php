<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use App\Model\Master_steps;
use App\Model\Passport\Passport;
use App\Model\VisaProcess\OwnVisa;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaPaymentOptions extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;

    public $table = "visa_payment_options";
    protected $fillable = ['passport_id','visa_process_step_id','payment_amount','payment_type','transaction_no','transaction_date_time','vat','other_attachment'];
    //
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }

    public function master()
    {
        return $this->belongsTo(Master_steps::class,'visa_process_step_id');
    }

    public function master_own()
    {
        return $this->belongsTo(OwnVisa::class,'own_visa_step');
    }
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
}
