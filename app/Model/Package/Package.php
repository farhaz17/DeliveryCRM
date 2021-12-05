<?php

namespace App\Model\Package;

use App\Model\Cities;
use App\Model\Platform;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Package extends Model
{
    //

    public function state_detail()
    {
        return $this->belongsTo(Cities::class,'state');
    }
    public function platform_detail()
    {
        return $this->belongsTo(Platform::class,'platform');
    }


    public function user_detail(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function user_ammend(){
        return $this->belongsTo(User::class,'user_id_ammend');
    }
}


