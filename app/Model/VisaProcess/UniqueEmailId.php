<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use Illuminate\Database\Eloquent\Model;
// use OwenIt\Auditing\Contracts\Auditable;

class UniqueEmailId extends Model
{
    // use \OwenIt\Auditing\Auditable;
    //

    //
    public $table = "unique_email_ids";
    protected $fillable = ['passport_id','status','issue_date','expiry_date'];
    public function attachment()
    {
        return $this->belongsTo(VisaAttachment::class,'attachment_id');
    }
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }
}
