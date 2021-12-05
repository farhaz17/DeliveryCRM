<?php

namespace App\Model\VisaProcess;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\VisaProcess\RenewAgreedAmount;

class RenewalEmiratesIdTyping extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    //

    public function renew_agreement()
    {
        return $this->belongsTo(RenewAgreedAmount::class,'renew_agreement_id');
    }


}
