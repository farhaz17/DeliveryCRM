<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rta_Vehicle extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "rta_vehicles";
    use SoftDeletes;
    protected $fillable=['mortgaged_by','insurance_co','expiry_date','issue_date','fines_amount','number_of_fines','registration_valid_for_days','make_year',
        'plate_no','chassis_no','model','traffic_file_number'];
}
