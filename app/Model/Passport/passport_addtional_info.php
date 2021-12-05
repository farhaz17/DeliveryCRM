<?php

namespace App\Model\Passport;

use App\Model\UserCodes\UserCodes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class passport_addtional_info extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "passport_additional_info";
    protected $fillable = ['passport_id','full_name','nat_name', 'nat_relation','nat_address','nat_phone','nat_whatsapp_no','nat_email','inter_name','inter_relation','inter_address','inter_phone','inter_whatsapp_no','inter_email','personal_mob','personal_email'];

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }


}
