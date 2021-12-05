<?php

namespace App\Model\Notice;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Notice extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
