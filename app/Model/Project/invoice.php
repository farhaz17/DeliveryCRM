<?php

namespace App\Model\Project;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Passport\passport_addtional_info;

class invoice extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function project_names(){
        return $this->belongsTo(Project::class,'project_id');
    }

    public function names(){
        return $this->belongsTo(Passport::class,'person_name');
    }
}
