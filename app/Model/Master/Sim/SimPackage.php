<?php

namespace App\Model\Master\Sim;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SimPackage extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
