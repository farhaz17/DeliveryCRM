<?php

namespace App\Model\PlatformCode;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Model\PlatformCode\PlatformCode;
use OwenIt\Auditing\Contracts\Auditable;

class PlatformCodeUpdateHistory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function platform()
    {
        return $this->belongsTo(PlatformCode::class, 'user_id');
    }
}
