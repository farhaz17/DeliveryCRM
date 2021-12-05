<?php

namespace App\Model\Lpo;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LpoInvoice extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
