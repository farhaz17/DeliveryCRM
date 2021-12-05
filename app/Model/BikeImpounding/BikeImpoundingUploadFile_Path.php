<?php

namespace App\Model\BikeImpounding;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BikeImpoundingUploadFile_Path extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "bike_impounding_upload_file_paths";

    protected $fillable=['file_path'];

    public function bik_impounding_upload_detail(){
        return $this->hasMany(BikeImpoundingUpload::class,'bike_impounding_upload_file_path_id','id');
    }

    public function total_bike_instead_booking(){
        return $this->bik_impounding_upload_detail()->sum('value_instead_of_booking');
    }

    public function bike_impounding_count(){
        return $this->bik_impounding_upload_detail()->count();
    }
}
