<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Ticket_assign_logs\Ticket_assign_logs;

class Ticket extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['platform','platform_id','message','department_id','image_url','voice_message',
                'closed_by' , 'is_approved'];

    public function department()
    {
        return $this->belongsTo(Departments::class,'department_id');
    }

    public function current_department()
    {
        return $this->belongsTo(Departments::class,'processing_by');
    }

    public function ticket_log()
    {
        return $this->belongsTo(Ticket_assign_logs::class,'ticket_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function user_ticket()
    {
        return $this->belongsTo(User::class,'user_id')->select(['id']);
    }

    public function closed_name()
    {
        return $this->belongsTo(User::class,'closed_by');
    }


    public function platform_()
    {
        return $this->belongsTo(Platform::class,'platform');
    }

    public function ticket_activity(){
        return $this->hasMany(TicketActivity::class,'ticket_id','id');
    }

    public function ticket_message(){
        return $this->hasMany(TicketMessage::class,'ticket_id','id');
    }

    public function ticket_message_public(){
        return $this->hasMany(TicketMessage::class,'ticket_id','id')->where('category','=','2');
    }

    public function unread_message(){

        return  $this->hasMany(TicketMessage::class,'ticket_id','id')
                            ->where('user_type','=','1')
                            ->where('is_read','1');

    }

    public function not_read_message(){

        return  $this->hasMany(TicketMessage::class,'ticket_id','id')
            ->where('user_type','=','1')
            ->where('is_read','1')->count();
    }
    public function count_message(){
        return $this->unread_message()->count() ? $this->not_read_message()->count() : 0 ;
    }


    public function scopeIsActiveShop($query,$users_new_array = []) {
        return $query->whereIn('assigned_to', $users_new_array);
    }




}
