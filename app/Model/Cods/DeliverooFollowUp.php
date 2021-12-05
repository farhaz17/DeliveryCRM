<?php

namespace App\Model\Cods;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DeliverooFollowUp extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['user_id', 'passport_id', 'cod_upload_id', 'feedback_id', 'remarks'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
