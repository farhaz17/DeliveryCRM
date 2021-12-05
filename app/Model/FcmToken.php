<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FcmToken extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
