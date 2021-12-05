<?php

namespace App\Model\Riders\DefaulterRiders;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Riders\DefaulterRiders\DefaulterRider;

class DefaulterRiderDrcAssign extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = ['drcm_id', 'drc_id', 'defaulter_rider_id', 'approval_status','status'];

    public function drcm()
    {
        return $this->belongsTo(User::class, 'drcm_id');
    }
    public function drc()
    {
        return $this->belongsTo(User::class, 'drc_id');
    }
    public function defaulter_rider()
    {
        return $this->belongsTo(DefaulterRider::class, 'defaulter_rider_id');
    }

    public function defaulter_reassign_request_remove()
    {

        return $this->hasMany(DefalterRiderReassignRequest::class, 'defaulter_rider_id','defaulter_rider_id');
    }

}
