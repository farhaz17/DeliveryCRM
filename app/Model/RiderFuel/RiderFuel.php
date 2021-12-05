<?php

namespace App\Model\RiderFuel;

use App\User;
use App\Model\Platform;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RiderFuel extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function platform(){
        return $this->belongsTo(Platform::class,'platform_id');
    }

    public function action_user_by(){
        return $this->belongsTo(User::class,'action_by','id');
    }

}
