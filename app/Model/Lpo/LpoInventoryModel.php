<?php

namespace App\Model\Lpo;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LpoInventoryModel extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function model()
    {
        return $this->morphTo();
    }
}
