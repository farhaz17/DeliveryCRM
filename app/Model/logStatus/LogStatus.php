<?php

namespace App\Model\logStatus;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LogStatus extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
