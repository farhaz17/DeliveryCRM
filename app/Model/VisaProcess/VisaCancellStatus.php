<?php

namespace App\Model\VisaProcess;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaCancellStatus extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
}
