<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uber extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "uber";
    use SoftDeletes;
    protected $fillable=['name','cash','credit'];
}
