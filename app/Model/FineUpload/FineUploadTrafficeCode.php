<?php

namespace App\Model\FineUpload;

use Illuminate\Database\Eloquent\Model;
use App\Model\Seeder\CompanyInformation;
use OwenIt\Auditing\Contracts\Auditable;

class FineUploadTrafficeCode extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $table ="fine_upload_traffic_codes";
    //
    protected $fillable=['traffic_file_no'];

    public function company_info(){
       return  $this->belongsTo(CompanyInformation::class,'traffic_file_no','traffic_fle_no');
    }

    public function fine_upload_detail(){
        return $this->hasMany(FineUpload::class,'fine_upload_traffic_code_id','id');
    }

    public function fine_upload_total_amount(){
        return $this->fine_upload_detail()->sum('ticket_fee');
    }

    public function fine_upload_total_count(){
        return $this->fine_upload_detail()->count();
    }
    // public function fine_upload_not_matched(){



    //     $checkindata = AssignBike::where('checkin', '<=',$fine_date)
    //     ->where('bike','=',$array_ab[1])
    //     ->first();


    // }
}
