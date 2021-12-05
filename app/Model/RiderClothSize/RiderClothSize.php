<?php

namespace App\Model\RiderClothSize;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RiderClothSize extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
