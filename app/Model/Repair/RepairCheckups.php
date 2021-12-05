<?php

namespace App\Model\Repair;

use App\Model\ManageRepair;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RepairCheckups extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function manage_repair()
    {
        return $this->belongsTo(ManageRepair::class,'manage_repair_id');
    }
}
