<?php

namespace App\Model;

use App\User;
use App\Model\Seeder\LivingStatus;
use App\Model\Seeder\UserCurrentStatus;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VerificationForm extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function platform(){
        return $this->belongsTo(Platform::class,'platform_id');
    }
    public function status_change_by()
    {
        return $this->belongsTo(User::class,'verify_by');
    }



    public function live_status(){
        return $this->belongsTo(LivingStatus::class,'user_id');
    }

    public function live_status_name(){
        return $this->belongsTo(UserCurrentStatus::class,'user_id');
    }
}
