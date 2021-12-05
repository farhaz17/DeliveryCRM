<?php

namespace App\Model\VisaProcess;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaClearance extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable=['passport_id','cancallation_id','payroll_status','maintenance_status','operation_status','pro_status'];

    public function clear()
    {
        return $this->belongsTo(VisaCancallation::class,'cancallation_id');
    }
}
