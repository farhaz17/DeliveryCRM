<?php

namespace App\Model\Price;

use App\User;
use App\Model\Parts;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PriceHistory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function parts()
    {
        return $this->belongsTo(Parts::class,'part_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'added_by');
    }
}
