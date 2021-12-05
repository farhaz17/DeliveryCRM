<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RenewVisaPaymentOption extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }
}
