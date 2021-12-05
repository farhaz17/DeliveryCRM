<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TicketActivity extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function ticket()
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }

    public function from_department()
    {
        return $this->belongsTo(Departments::class,'assigned_from');
    }

    public function to_department()
    {
        return $this->belongsTo(Departments::class,'assigned_to');
    }

    public function from_major_department()
    {
        return $this->belongsTo(MajorDepartment::class,'assigned_from');
    }

    public function to_major_department()
    {
        return $this->belongsTo(MajorDepartment::class,'assigned_to');
    }

    public function assigned_by(){
        return $this->belongsTo(User::class,'assigned_user_by');
    }
}
