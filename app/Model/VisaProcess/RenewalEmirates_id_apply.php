<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RenewalEmirates_id_apply extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }
}
