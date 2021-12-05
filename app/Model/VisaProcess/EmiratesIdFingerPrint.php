<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EmiratesIdFingerPrint extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public $table = "emirates_id_finger_prints";
    protected $fillable = ['passport_id','status'];
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }
}
