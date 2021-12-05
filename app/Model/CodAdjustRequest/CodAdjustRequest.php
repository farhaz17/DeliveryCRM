<?php

namespace App\Model\CodAdjustRequest;

use App\User;
use App\Model\RiderProfile;
use App\Model\Passport\Passport;
use App\Model\CodUpload\CodUpload;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CodAdjustRequest extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function passport()
    {
        return $this->belongsTo(Passport::class, 'passport_id');
    }
    public function verify_by()
    {
        return $this->belongsTo(User::class, 'verify_by');
    }
    public function get_amount()
    {
        return $this->belongsTo(CodUpload::class, 'order_id', 'order_id');
    }

}
