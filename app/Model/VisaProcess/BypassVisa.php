<?php

namespace App\Model\VisaProcess;

use App\User;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BypassVisa extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public function passport(){
        return $this->belongsTo(Passport::class,'passport_id');
      }
      public function user_info(){
        return $this->belongsTo(User::class,'user_id');
      }
}
