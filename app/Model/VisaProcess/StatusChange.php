<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\VisaProcess\VisaAttachment;

class StatusChange extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public $table = "status_changes";
    protected $fillable = ['passport_id','outside_entry_date','expiry_date','payment_amount','payment_type','transaction_no','transaction_date_time','vat','attachment_id',
        'fine','type','proof'];
    public function attachment()
    {
        return $this->belongsTo(VisaAttachment::class,'attachment_id');
    }
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }
}
