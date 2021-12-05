<?php

namespace App\Model\Passport;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PassportRequest extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
}
