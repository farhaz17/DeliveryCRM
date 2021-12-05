<?php

namespace App\Model\Offer_letter;

use App\Model\PaymentType;
use App\Model\Seeder\Company;
use App\Model\Passport\Passport;
use App\Model\Seeder\Designation;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\VisaProcess\VisaAttachment;
use App\Model\ElectronicApproval\ElectronicPreApproval;

class Offer_letter extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "offer_letters";
    protected $fillable = ['passport_id','st_no','company','job', 'date_and_time','payment_amount','payment_type','transaction_no','transaction_date_time','vat','attachment_id'];

    public function attachment()
    {
        return $this->hasOne(VisaAttachment::class,'table_id','id');
    }
    public function companies()
    {
        return $this->belongsTo(Company::class,'company');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class,'job');
    }
    public function payment()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }

    public function passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function get_pre_approval(){
        return $this->hasMany(ElectronicPreApproval::class,'passport_id','passport_id');
    }

    public function mb_no(){
        return $this->hasOne(Offer_letter_submission::class);
    }


}
