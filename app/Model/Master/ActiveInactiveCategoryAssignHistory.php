<?php

namespace App\Model\Master;

use App\User;
use App\CommonStatus;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use App\Model\Master\ActiveInactiveSubCategory;
use App\Model\Master\ActiveInactiveCategoryMain;

class ActiveInactiveCategoryAssignHistory extends Model
{
    protected $with = ['passport', 'main_cate', 'sub_cate1', 'user'];
    protected $fillable = ['passport_id', 'main_category', 'sub_category1', 'user_id', 'common_status_id'];
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
}
