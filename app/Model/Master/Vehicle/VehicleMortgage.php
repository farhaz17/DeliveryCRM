<?php

namespace App\Model\Master\Vehicle;

use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleMortgage extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = ['name'];
    public function bikes()
    {
        return $this->hasMany(BikeDetail::class,'mortgaged_by');
    }
}
