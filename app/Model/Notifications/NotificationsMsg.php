<?php

namespace App\Model\Notifications;

use App\Model\Platform;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class NotificationsMsg extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function plateforms_name()
    {
        return $this->belongsTo(Platform::class,'plateform_id');
    }
}
