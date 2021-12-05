<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Master_steps extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "master_steps";
    protected $fillable = ['step_name'];
}
