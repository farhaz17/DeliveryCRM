<?php

namespace App\Model\UserCodes;

use App\Model\Platform;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserCodes extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public $table = "user_codes";
    protected $fillable = ['passport_id', 'plateform','plateform_id','plateform_code','zds_code'];

//    public function platform_codes()
//    {
//        return $this->hasMany(Passport::class);
//    }

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }



    public function platform_name()
    {
        return $this->belongsTo(Platform::class,'plateform_id');
    }

}
