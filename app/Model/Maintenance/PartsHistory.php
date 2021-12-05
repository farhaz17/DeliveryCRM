<?php

namespace App\Model\Maintenance;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PartsHistory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
}
