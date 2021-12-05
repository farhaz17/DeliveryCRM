<?php

namespace App\Model\VisaProcess;

use App\User;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaCancallation extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable=['passport_id','zds_code','cancallation_type','resignation_type','remarks','date_until_works',
        'start_cancel_date' , 'approval_status','hold_status','added_by'];

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function user_name()
    {
        return $this->belongsTo(User::class,'added_by');
    }

}
