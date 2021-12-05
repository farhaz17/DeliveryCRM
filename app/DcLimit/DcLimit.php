<?php

namespace App\DcLimit;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DcLimit extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'user_id',
        'limit'
    ];


}
