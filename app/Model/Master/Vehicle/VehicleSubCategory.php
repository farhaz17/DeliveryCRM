<?php

namespace App\Model\Master\Vehicle;

use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleSubCategory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = ['vehicle_category_id', 'name'];
    public function parent_category()
    {
        return $this->belongsTo(VehicleCategory::class,'vehicle_category_id');
    }
    public function bikes()
    {
        return $this->hasMany(BikeDetail::class,'vehicle_sub_category_id');
    }
    
}
