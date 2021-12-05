<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Offer_letter\Offer_letter_submission;

class VisaAttachment extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //


    public $table = "visa_attachments";
    protected $fillable = ['attachment_name', 'table_id'];

    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }

}
