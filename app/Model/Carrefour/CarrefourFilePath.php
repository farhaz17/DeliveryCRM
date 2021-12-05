<?php

namespace App\Model\Carrefour;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CarrefourFilePath extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
