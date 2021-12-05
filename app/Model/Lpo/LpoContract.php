<?php

namespace App\Model\Lpo;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Master\CustomerSupplier\CustomerSupplier;

class LpoContract extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function supplier() {
        return $this->belongsTo(CustomerSupplier::class);
    }
}
