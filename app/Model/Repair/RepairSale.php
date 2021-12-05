<?php

namespace App\Model\Repair;

use App\Model\BikeDetail;
use App\Model\ManageRepair;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RepairSale extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['data','status','inv_status','manage_repair_id'];

    public function manage_repair()
    {
        return $this->belongsTo(ManageRepair::class, 'manage_repair_id');
    }

    // protected $casts = [
    //     'data' => 'object'
    // ];

}
