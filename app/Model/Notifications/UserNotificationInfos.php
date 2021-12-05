<?php

namespace App\Model\Notifications;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserNotificationInfos extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
