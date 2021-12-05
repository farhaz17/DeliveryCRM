<?php

namespace App\Model\Lpo;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LpoPayment extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function cheque() {
        return $this->belongsTo(LpoCheque::class, 'cheque_id');
    }
}
