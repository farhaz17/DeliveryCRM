<?php

namespace App\Model\VisaProcess\VisaCancel;

use App\User;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaCancelRequest extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public function user_detail()
    {
        return $this->belongsTo(User::class,'requsted_by');
    }
    public function passport(){
            return $this->belongsTo(Passport::class,'passport_id');
    }
    public function removed_detail()
    {
        return $this->belongsTo(User::class,'removed_by');
    }
    public function accept_detail()
    {
        return $this->belongsTo(User::class,'accepted_by');
    }



}
