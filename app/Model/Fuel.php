<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fuel extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable=['rid','vehicle_plate_number','license_plate_nr','sale_end','unit_price','volume','total','product_name','receipt_nr','odometer',
        'id_unit_code','station_name','station_code','fleet_name','p_product_name','group_name','vehicle_code','city_code','cost_center',
        'vat_rate','vat_amount','actual_amount'];

}
