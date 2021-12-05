<?php

namespace App\Model\TicketProblem;

use App\Model\Departments;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TicketProblem extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public function issus(){
        return $this->hasMany(Departments::class,'ticket_problem_id','id');
    }
}
