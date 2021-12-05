<?php

namespace App\Model\Master\Company;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MasterMajorCategory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
