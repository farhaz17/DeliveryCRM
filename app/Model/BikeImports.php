<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BikeImports extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $table = "bike_imports";

    protected $fillable=['plate_no','plate_code','model','make_year',
        'chassis_no','mortgaged_by','insurance_co','expiry_date','issue_date','traffic_file','category_types'];
}



//Plate No,  Plate Code, Model,  Make Year , Chassis no,Mortgaged by,Insurance Co.:,ExpiryDate,IssueDate,Traffic File
