<?php

namespace App\Model\FourPl;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FourPlUser extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];
}
