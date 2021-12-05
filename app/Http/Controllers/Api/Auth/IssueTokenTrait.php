<?php

namespace App\Http\Controllers\Api\Auth;

use App\Model\RiderProfile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

trait IssueTokenTrait{

    public function issueToken(Request $request,$grandType,$scope ="*"){


        $params = [
            'grant_type' => $grandType,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $request->username?:$request->email,
            'scope' =>$scope
        ];

        $request -> request->add($params);

        $proxy = Request::create('oauth/token','POST');

//    dd($user_detail->id);


        return Route::dispatch($proxy);


    }
}
