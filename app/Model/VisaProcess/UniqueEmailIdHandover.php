<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UniqueEmailIdHandover extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public $table = "unique_email_id_handovers";
    protected $fillable = ['passport_id','status'];
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }

    public function passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function handover_person(){
        return $this->belongsTo(Passport::class,'handover_person_name');
    }

}
