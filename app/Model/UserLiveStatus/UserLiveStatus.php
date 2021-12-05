<?php

namespace App\Model\UserLiveStatus;

use App\Model\Seeder\UserCurrentStatus;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserLiveStatus extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //


    public function live_status_name(){
        return $this->belongsTo(UserCurrentStatus::class,'user_current_status_id');
    }
}
