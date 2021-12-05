<?php

namespace App\Model\Passport;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RenewPassport extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "renew_passports";
    protected $fillable = ['passport_id', 'renew_passport_number','renew_passport_issue_date','renew_passport_expiry_date','attachment'];

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

}
