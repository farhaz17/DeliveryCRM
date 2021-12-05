<?php

namespace App\Model\VisaProcess\VisaCencel;

use App\Model\PaymentType;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaCancellationApproval extends Model  implements Auditable
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
}
