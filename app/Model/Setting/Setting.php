<?php

namespace App\Model\Setting;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Setting extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
}
