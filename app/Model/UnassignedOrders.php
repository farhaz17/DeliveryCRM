<?php

namespace App\Model;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UnassignedOrders extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function platform(){
        return $this->belongsTo(Platform::class,'platform_id');
    }
}
