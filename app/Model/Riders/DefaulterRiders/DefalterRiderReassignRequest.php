<?php

namespace App\Model\Riders\DefaulterRiders;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Riders\DefaulterRiders\DefaulterRider;

class DefalterRiderReassignRequest extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = ['defaulter_rider_id', 'requested_to_dc_id', 'requested_by', 'approved_by', 'approval_status'];
    public function defaulter_rider()
    {
        return $this->belongsTo(DefaulterRider::class, 'defaulter_rider_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
    public function acceptor()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function requested_to_dc()
    {
        return $this->belongsTo(User::class, 'requested_to_dc_id');
    }

}
