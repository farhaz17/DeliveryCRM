<?php

namespace App\Model\DepartmentContact;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DepartmentContact extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "department_contacts";
}
