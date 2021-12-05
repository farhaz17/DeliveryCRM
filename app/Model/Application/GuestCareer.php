<?php

namespace App\Model\Application;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class GuestCareer extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
