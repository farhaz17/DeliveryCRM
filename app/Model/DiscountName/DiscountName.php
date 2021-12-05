<?php

namespace App\Model\DiscountName;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DiscountName extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
