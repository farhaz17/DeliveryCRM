<?php

namespace App\Model\It_tickets;

use App\User;
use App\Model\Uber;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class It_tickets extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function user_name()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
