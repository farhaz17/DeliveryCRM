<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use Illuminate\Database\Eloquent\Model;
// use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Passport\Passport;

class RenewalContractTyping extends Model  
{
    // use \OwenIt\Auditing\Auditable;
    //

    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
}
