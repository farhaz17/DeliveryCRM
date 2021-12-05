<?php

namespace App\Model\Project;

use App\Model\Seeder\Company;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function company_name(){
        return $this->belongsTo(Company::class,'company');
    }

    // public function c(){
    //     return $this->belongsTo(Company::class,'company');
    // }
}
