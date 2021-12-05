<?php

namespace App\Model\Career;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class waitlistfollowup extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
