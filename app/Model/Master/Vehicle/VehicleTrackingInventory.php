<?php

namespace App\Model\Master\Vehicle;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleTrackingInventory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = ['tracking_no','status','lpo_id','uploaded_file_path'];
}
