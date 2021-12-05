<?php

namespace App\Model;

use App\User;
use App\Model\Master\FourPl;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VendorRiderOnboard extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(Passport\Passport::class,'passport_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'received_from');
    }

    public function personal_info(){
        return $this->belongsTo(Passport\passport_addtional_info::class, 'passport_id', 'passport_id');
    }
    public function vendor()
    {
        return $this->belongsTo(FourPl::class, 'four_pls_id');
    }
}
