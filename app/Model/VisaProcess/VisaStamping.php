<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaStamping extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public $table = "visa_stampings";
    protected $fillable = ['passport_id','payment_amount','payment_type','transaction_no','transaction_date_time','vat','fine','type','proof'];
    public function attachment()
    {
        return $this->belongsTo(VisaAttachment::class,'attachment_id');
    }
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }
}
