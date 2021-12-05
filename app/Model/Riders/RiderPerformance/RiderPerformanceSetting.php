<?php

namespace App\Model\Riders\RiderPerformance;

use App\Model\Platform;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Riders\RiderPerformance\RiderPerformanceSetting;

class RiderPerformanceSetting extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'setting_name',
        'setting_description',
        'platform_id',
        'column_settings',
        'performance_model',
        'date_column_name',
        'status'
    ];
    protected $casts = [
        'column_settings' => 'json'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            Self::wherePlatformId($model->platform_id)->get()->map(function($setting){
                $setting->update([
                    'status' => 0
                ]);
            });
        });
    }
    protected $with = ['platform'];
    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }
}
