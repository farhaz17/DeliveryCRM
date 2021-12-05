<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RepairUsedParts extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['repair_job_id','part_id','quantity'];

    public function part()
    {
        return $this->belongsTo(Parts::class,'part_id');
    }
    public function repair_job()
    {
        return $this->belongsTo(ManageRepair::class,'repair_job_id');
    }
}
