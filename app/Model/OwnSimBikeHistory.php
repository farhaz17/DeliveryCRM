<?php

namespace App\Model;

use  App\Model\Platform;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OwnSimBikeHistory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }


    public  function get_platform(){

        return $this->belongsTo(Platform::class,'platform_id');
    }
}
