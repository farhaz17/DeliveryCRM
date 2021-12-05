<?php

namespace App\Model\UserCodes;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserIds extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public $table = "user_ids";
    protected $fillable = ['passport_id', 'zds_id1','zds_id2','labour_card_no'];

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
}
