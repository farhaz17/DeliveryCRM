<?php

namespace App\Model\LogAfterPpuid;

use App\Model\logStatus\LogStatus;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LogAfterPpuid extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function log_status(){
       return $this->belongsTo(LogStatus::class,'log_status_id');
     }
}
