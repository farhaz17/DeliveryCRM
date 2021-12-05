<?php

namespace App\Model\BikeImpounding;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BikeImpoundingUpload extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['bike_impounding_upload_file_path_id',
        'plate_number',
        'plate_category',
        'ticket_number',
        'ticket_date',
        'ticket_time',
        'value_instead_of_booking',
        'number_of_days_of_booking',
        'text_violation'

    ];

    public function excel_sheet(){
        return $this->belongsTo(BikeImpoundingUploadFile_Path::class, 'bike_impounding_upload_file_path_id', 'id');
    }
}
