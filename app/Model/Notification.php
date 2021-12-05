<?php

namespace App\Model;

use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class Notification extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public static function singleDevice($token,$title,$body,$activity){

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
            ->setSound('default');
        $notificationBuilder->setClickAction($activity);

        $dataBuilder = new PayloadDataBuilder();

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = $token;
// dd($notification);
        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        $downstreamResponse->tokensToDelete();

        $downstreamResponse->tokensToModify();

        $downstreamResponse->tokensToRetry();

        $downstreamResponse->tokensWithError();
    }

//    public static function multipleDevice($token,$title,$body,$clickaction){
//
//        $optionBuilder = new OptionsBuilder();
//        $optionBuilder->setTimeToLive(60*20);
//
//        $notificationBuilder = new PayloadNotificationBuilder('my title');
//        $notificationBuilder->setBody('Hello world')
//            ->setSound('default');
//
//        $dataBuilder = new PayloadDataBuilder();
//        $dataBuilder->addData(['a_data' => 'my_data']);
//
//        $option = $optionBuilder->build();
//        $notification = $notificationBuilder->build();
//        $data = $dataBuilder->build();
//
//        $tokens = MYDATABASE::pluck('fcm_token')->toArray();
//
//        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
//
//        $downstreamResponse->numberSuccess();
//        $downstreamResponse->numberFailure();
//        $downstreamResponse->numberModification();
//
//        $downstreamResponse->tokensToDelete();
//
//        $downstreamResponse->tokensToModify();
//
//        $downstreamResponse->tokensToRetry();
//
//        $downstreamResponse->tokensWithError();
//
//    }
}
