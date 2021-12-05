<?php

namespace App\Model\Jobs;

use App\Model\Cities;
use App\Model\Seeder\Company;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CreateJobs extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function states_detail()
    {
        return $this->belongsTo(Cities::class,'state');
    }
    public function comp_detail()
    {
        return $this->belongsTo(Company::class,'company');
    }
}
