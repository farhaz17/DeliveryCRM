<?php

namespace App\Model\Master\Vehicle;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehiclePlateReplace extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
}
