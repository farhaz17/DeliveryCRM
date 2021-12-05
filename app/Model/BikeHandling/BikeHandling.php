<?php

namespace App\Model\BikeHandling;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BikeHandling extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
}
