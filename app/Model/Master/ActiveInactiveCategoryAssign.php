<?php

namespace App\Model\Master;

use App\User;
use App\CommonStatus;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Master\ActiveInactiveCategoryAssignHistory;

class ActiveInactiveCategoryAssign extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $with = ['passport', 'main_cate', 'sub_cate1', 'user'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            ActiveInactiveCategoryAssignHistory::create([
                'user_id' => auth()->id() ?? null,
                "passport_id" => $model->passport_id,
                "main_category" => $model->main_category,
                "sub_category1" => $model->sub_category1,
                "common_status_id" => $model->common_status_id,
            ]);
        });
        static::updating(function ($model) {
            ActiveInactiveCategoryAssignHistory::create([
                'user_id' => auth()->id() ?? null,
                "passport_id" => $model->passport_id,
                "main_category" => $model->main_category,
                "sub_category1" => $model->sub_category1,
                "common_status_id" => $model->common_status_id,
            ]);
        });
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function main_cate()
    {
        return $this->belongsTo(ActiveInactiveCategoryMain::class,'main_category');
    }
    public function sub_cate1()
    {
        return $this->belongsTo(ActiveInactiveSubCategory::class,'sub_category1');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function history()
    {
        return $this->hasMany(ActiveInactiveCategoryAssignHistory::class);
    }
}
