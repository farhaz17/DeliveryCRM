<?php

namespace App\VisaProcess;

use App\User;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ReplacementRequest extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public function passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function passport_two(){
        return $this->belongsTo(Passport::class,'replace_to_passport_id');
    }
    public function user_detail(){
        return $this->belongsTo(User::class,'requested_by');
    }
}
