<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Manager_users extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'manager_user_id',
        'member_user_id',
        'status'
    ];

    public function manager_user_detail(){
        return $this->belongsTo(User::class,'manager_user_id','id');
    }

    public function user_detail(){
        return $this->belongsTo(User::class,'member_user_id','id');
    }


}
