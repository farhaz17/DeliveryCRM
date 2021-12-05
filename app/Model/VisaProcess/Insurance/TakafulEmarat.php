<?php

namespace App\Model\VisaProcess\Insurance;

use App\User;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Vehicle\InsuranceNetworkType;
use App\Model\Master\Vehicle\VehicleInsurance;

class TakafulEmarat extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public function passport(){
        return $this->belongsTo(Passport::class,'passport_id');
      }
      public function user_info(){
        return $this->belongsTo(User::class,'user_id');
      }

      public function insurance_com(){
        return $this->belongsTo(VehicleInsurance::class,'insurance_company');
      }

      public function com_network(){
        return $this->belongsTo(InsuranceNetworkType::class,'network_type');
      }
}
