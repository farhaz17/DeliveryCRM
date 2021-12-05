<?php

namespace App\Model\Boxinstall;

use App\User;
use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BikeRenewal extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function bike()
    {
        return $this->belongsTo(BikeDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
