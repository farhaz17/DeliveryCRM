<?php

namespace App\Model\FineUpload;

use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FineUpload extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;

    protected $fillable=['fine_upload_traffic_code_id',
        'plate_number',
        'ticket_number',
        'ticket_date',
        'ticket_time',
        'fines_source',
        'ticket_fee',
        'offense',
        'plate_cateogry',
        'plate_code',
        'license_number',
        'license_from',
    ];

    public function  company_detail_info(){

       return $this->belongsTo(FineUploadTrafficeCode::class,'fine_upload_traffic_code_id','id');
    }

    public function bike_detail(){
        return $this->belongsTo(BikeDetail::class,'plate_number','plate_no');
    }



}
