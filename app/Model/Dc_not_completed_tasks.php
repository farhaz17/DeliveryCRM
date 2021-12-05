<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Dc_not_completed_tasks extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
