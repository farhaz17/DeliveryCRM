<?php

namespace App\Model\Ticket_assign_logs;

use App\User;
use App\Model\Ticket;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Ticket_assign_logs extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //


    public function user(){

        return $this->belongsTo(User::class,'user_id');
    }

    public function ticket(){

        return $this->belongsTo(Ticket::class,'ticket_id');
    }

}
