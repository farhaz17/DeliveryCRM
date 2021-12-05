<?php

namespace App\Model\Passport;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PassportLocker extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'received_from');
    }

    public function personal_info(){
        return $this->belongsTo(passport_addtional_info::class, 'passport_id', 'passport_id');
    }
}
