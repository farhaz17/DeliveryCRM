<?php

namespace App\Model\Cods;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CodActionHistory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
}
