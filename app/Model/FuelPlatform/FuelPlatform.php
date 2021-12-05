<?php

namespace App\Model\FuelPlatform;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FuelPlatform extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function platform()
    {
        return $this->belongsTo('App\Model\Platform');
    }
}
