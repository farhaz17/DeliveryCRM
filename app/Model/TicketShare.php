<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TicketShare extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function share()
    {
        return $this->belongsTo(User::class,'internal_dep_assign');
    }

    public function share_from()
    {
        return $this->belongsTo(User::class,'sent_by');
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class,'ticket_id');
    }


}
