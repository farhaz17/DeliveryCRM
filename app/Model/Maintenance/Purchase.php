<?php

namespace App\Model\Maintenance;

use App\Model\Parts;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Master\CustomerSupplier\CustomerSupplier;

class Purchase extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function suppliers()
    {
        return $this->belongsTo(CustomerSupplier::class, 'supplier');
    }

  

}
