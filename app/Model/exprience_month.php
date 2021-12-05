<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class exprience_month extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
