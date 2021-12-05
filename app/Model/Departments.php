<?php

namespace App\Model;

use App\Model\Agreement\Agreement;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departments extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function major_dep(){
        return $this->belongsTo(MajorDepartment::class,'major_dept_id');
    }
}
