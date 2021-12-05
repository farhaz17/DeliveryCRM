<?php

namespace App\Model;

use App\Model\Departments;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MajorDepartment extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    public function issue_dep()
    {
        return $this->hasMany(Departments::class,'major_dept_id');
    }
}
