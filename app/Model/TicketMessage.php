<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TicketMessage extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function ticket()
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


}
