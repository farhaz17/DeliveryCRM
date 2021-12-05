<?php

namespace App\Model;

use App\Model\Assign\AssignBike;
use Illuminate\Database\Eloquent\Model;
use App\Model\PlatformCode\PlatformCode;
use App\Model\Seeder\CompanyInformation;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle_salik extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable=['transaction_id','trip_date','trip_time','transaction_post_date','toll_gate','direction','tag_number','plate','amount','account_number','vehicle_salik_sheet_account_id'];

    public function get_account_detail(){
        return $this->belongsTo(Vehicle_salik_sheet_account::class,'vehicle_salik_sheet_account_id');
    }

    public function get_overwrite_date(){
        return $this->hasMany(VehicleSalikOtherTable::class);
    }

    public function overwrite_data(){
        return $this->hasOne(VehicleSalikOtherTable::class);
    }




    public function bike_detail(){
        return $this->belongsTo(BikeDetail::class,'plate','plate_no');
    }



}
