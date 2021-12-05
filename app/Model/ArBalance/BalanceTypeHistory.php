<?php

namespace App\Model\ArBalance;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BalanceTypeHistory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
