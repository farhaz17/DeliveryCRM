<?php

namespace App\Model;

use App\User;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Emirates_id_cards extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(Passport::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'enter_by');
    }
}
