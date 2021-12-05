<?php

namespace App\Model\PassportAttachment;

use App\Model\Nationality;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PassportAttachment extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function attach()
    {
        return $this->belongsTo(Nationality::class,'nation_id');
    }
}
