<?php

namespace App\Project;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
}
