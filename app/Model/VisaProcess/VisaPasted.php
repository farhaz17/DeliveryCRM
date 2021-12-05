<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
// use OwenIt\Auditing\Contracts\Auditable;

class VisaPasted extends Model
{
    // use \OwenIt\Auditing\Auditable;
    //
    public $table = "visa_pasteds";
    protected $fillable = ['passport_id','status','issue_date','expiry_date'];
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
