<?php

namespace App\Model\Assign;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AssignReport extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public  function users(){

        return $this->belongsTo(User::class,'verified_by');

    }
}
