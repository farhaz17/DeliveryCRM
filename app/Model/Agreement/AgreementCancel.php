<?php

namespace App\Model\Agreement;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AgreementCancel extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function agreement()
    {
        return $this->belongsTo(Agreement::class,'agrement_id');
    }
}
