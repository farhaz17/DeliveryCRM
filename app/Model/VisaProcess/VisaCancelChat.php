<?php

namespace App\Model\VisaProcess;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaCancelChat extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
