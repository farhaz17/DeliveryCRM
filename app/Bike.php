<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Bike extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'bikes';

    protected $casts = [
        'model' => 'varchar(255)',
        'chasis_no' => 'varchar(255)',
        'plate_no' => 'varchar(255)',
        'make_year' => 'varchar(255)',
        'company' => 'varchar(255)',
        'registration_valid' => 'varchar(255)',
        'no_of_fines' => 'varchar(255)',
        'fines_amount' => 'varchar(255)',
        'issue_date' => 'varchar(255)',
        'insurance_co' => 'varchar(255)',
        'mortaged_by' => 'varchar(255)'
    ];

    protected $fillable = [
        'model',
        'chasis_no',
        'plate_no',
        'make_year',
        'company',
        'registration_valid',
        'no_of_fines',
        'fines_amount',
        'issue_date',
        'insurance_co',
        'mortaged_by'
    ];
    public function getDateAttribute( ) {
        return (new Carbon($this->attributes['date']))->format('Y-m-d');
    }

}
