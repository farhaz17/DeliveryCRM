<?php

namespace App\Model\VisaProcess\VisaCancel;

use App\Model\PaymentType;
use App\Model\Master_steps;
use function PHPSTORM_META\map;
use App\Model\Passport\Passport;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BetweenVisaCancel extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public function payment()
  {
      return $this->belongsTo(PaymentType::class,'payment_type');
  }

  public function passport()
  {
      return $this->belongsTo(Passport::class,'passport_id');
  }

  public function master()
  {
      return $this->belongsTo(Master_steps::class,'visa_process_id');
  }

}
