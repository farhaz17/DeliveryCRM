<?php

namespace App\Model\Master\Vehicle;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VehicleStatusChangeHistory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $table = 'vehicle_status_change_history';
}
