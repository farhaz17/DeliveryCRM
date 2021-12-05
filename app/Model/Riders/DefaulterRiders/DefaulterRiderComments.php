<?php

namespace App\Model\Riders\DefaulterRiders;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefaulterRiderComments extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable = ['defaulter_rider_id','commenter_id','comment'];

    public function commenter()
    {
        return $this->belongsTo(User::class, 'commenter_id');
    }
}
