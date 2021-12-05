<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefaulterRiders extends Model  implements Auditable
{
    use SoftDeletes;
    use  \OwenIt\Auditing\Auditable;
    protected $fillable = ['user_id', 'passport_id', 'remarks', 'status'];
}
