<?php

namespace App\Model\ElectronicApproval;

use App\Model\PaymentType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\VisaProcess\VisaAttachment;
use App\Model\Passport\Passport;

class ElectronicPreApprovalPayment extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $table = "electronic_pre_approval_payments";
    protected $fillable = ['passport_id','mb_no', 'labour_card_no','issue_date','expiry_date','payment_amount','payment_type','transaction_no','transaction_date_time','vat','final_amount','expiry_date'];
    public function attachment()
    {
        return $this->belongsTo(VisaAttachment::class,'attachment_id');
    }
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

}
