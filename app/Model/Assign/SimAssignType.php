<?php

namespace App\Model\Assign;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SimAssignType extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "sim_assign_types";
    protected $fillable=['name'];
}
