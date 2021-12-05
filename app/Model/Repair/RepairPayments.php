<?php

namespace App\Model\Repair;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RepairPayments extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function repair()
    {
        return $this->belongsTo(RepairSale::class, 'repair_id');
    }
}
