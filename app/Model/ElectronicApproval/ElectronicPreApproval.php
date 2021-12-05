<?php

namespace App\Model\ElectronicApproval;

use App\Model\PaymentType;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use App\Model\Offer_letter\Offer_letter;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\VisaProcess\VisaAttachment;

class ElectronicPreApproval extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "electronic_pre_approval";
    protected $fillable = ['passport_id','mb_no','person_code', 'labour_card_no','issue_date','expiry_date','payment_amount','payment_type','transaction_no','transaction_date_time','vat','attachment_id'];

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

    public function offer()
    {
        return $this->belongsTo(Offer_letter::class,'passport_id');

    }


}
