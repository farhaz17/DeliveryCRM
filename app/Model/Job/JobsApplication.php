<?php

namespace App\Model\Job;

use App\Model\Jobs\CreateJobs;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class JobsApplication extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function jobs_created()
    {
        return $this->belongsTo(CreateJobs::class,'job_id');
    }
}
