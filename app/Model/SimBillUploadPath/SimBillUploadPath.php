<?php

namespace App\Model\SimBillUploadPath;

use App\Model\SimBills;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SimBillUploadPath extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public function simbill_detail(){
        return $this->hasMany(SimBills::class);
    }

    public function total_amount_to_pay(){
        return $this->simbill_detail()->sum('amount_to_pay');
    }
    public function total_amount_due(){
        return $this->simbill_detail()->sum('total_amount_due');
    }

}
