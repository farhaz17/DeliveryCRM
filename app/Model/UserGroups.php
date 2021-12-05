<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserGroups extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
