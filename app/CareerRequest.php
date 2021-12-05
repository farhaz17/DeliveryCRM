<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerRequest extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
}
