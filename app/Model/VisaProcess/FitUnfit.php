<?php

namespace App\Model\VisaProcess;

use App\Model\PaymentType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FitUnfit extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public $table = "fit_unfits";
    protected $fillable = ['passport_id','status','attachment_id'];

    public function attachment()
    {
        return $this->belongsTo(VisaAttachment::class,'attachment_id');
    }
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }

}
