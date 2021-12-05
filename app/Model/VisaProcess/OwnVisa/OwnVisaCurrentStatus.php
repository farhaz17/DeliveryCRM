<?php

namespace App\Model\VisaProcess\OwnVisa;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OwnVisaCurrentStatus extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
}
