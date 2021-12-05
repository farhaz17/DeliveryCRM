<?php

namespace App\Model\Cashreceives;

use App\User;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Cashreceives extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public function passport()
    {
        return $this->belongsTo(Passport::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'received_by');
    }
}
