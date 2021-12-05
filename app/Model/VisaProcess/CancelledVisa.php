<?php

namespace App\Model\VisaProcess;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CancelledVisa extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable=['passport_id','can_status','cancallation_id','status'];
    public function clear_visa()
    {
        return $this->belongsTo(VisaCancallation::class,'cancallation_id');
    }
    public function reason()
    {
        return $this->belongsTo(VisaCancellStatus::class,'can_status');
    }
}
