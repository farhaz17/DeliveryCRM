<?php

namespace App\Model\VisaProcess\OwnVisa;

use App\User;
use App\Model\PaymentType;
use Laravel\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OwnVisaLabourCardApproval extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }
    public function passport(){
      return $this->belongsTo(Passport::class,'passport_id');
    }
    public function user_detail()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
