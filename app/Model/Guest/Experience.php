<?php

namespace App\Model\Guest;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Experience extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "experiences";
}
