<?php

namespace App\Model\Master;

use App\User;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FourPl extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    public function user_detail(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
}
