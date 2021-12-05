<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LabourCardTypeAssign extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(\App\Model\Passport\Passport::class,'passport_id');
    }

    public function card_type_name()
    {
        return $this->belongsTo(LabourCardType::class,'labour_card_type_id','id');
    }
}
