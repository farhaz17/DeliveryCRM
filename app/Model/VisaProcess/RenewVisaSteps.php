<?php

namespace App\Model\VisaProcess;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RenewVisaSteps extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public $table = "renew_visa_steps";
    protected $fillable = ['step_name'];

}
