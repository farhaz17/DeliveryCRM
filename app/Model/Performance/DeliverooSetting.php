<?php

namespace App\Model\Performance;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DeliverooSetting extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
