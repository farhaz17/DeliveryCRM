<?php

namespace App\Model\RiderZone;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Zone extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['name'];
    /**
     * Set the Zone's name.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
    /**
     * Get the Zone's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
