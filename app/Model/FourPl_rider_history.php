<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FourPl_rider_history extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
