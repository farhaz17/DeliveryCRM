<?php

namespace App\Model\Lpo;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LpoCheque extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function lpo() {
        return $this->belongsTo(LpoMaster::class, 'assigned_to');
    }
}
