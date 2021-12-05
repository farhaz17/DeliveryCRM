<?php

namespace App\Model\Offer_letter;

use App\Model\PaymentType;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\VisaProcess\VisaAttachment;

class Offer_letter_submission extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "offer_letter_submission";
    protected $fillable = ['passport_id','mb_no', 'date_and_time','sub_attachment','payment_amount','payment_type','transaction_no','transaction_date_time','vat','attachment_id'];

    public function attachment()
    {
        return $this->belongsTo(VisaAttachment::class,'attachment_id');
    }
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }
}
