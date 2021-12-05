<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Cities extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['name','city_code'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function rider_zones(): HasMany
    {
        return $this->hasMany(Zone::class,'city_id');
    }
}
