<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EntryPrintOutside extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public $table = "entry_print_inside_outside";
    protected $fillable = ['passport_id','type','visa_number', 'uid_no','visa_issue_date','visa_expiry_date','payment_amount','payment_type','transaction_no','transaction_date_time','vat'];
    public function attachment()
    {
        return $this->belongsTo(VisaAttachment::class,'attachment_id');
    }
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }
}
