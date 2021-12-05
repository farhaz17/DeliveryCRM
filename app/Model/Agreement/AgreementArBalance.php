<?php

namespace App\Model\Agreement;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AgreementArBalance extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
