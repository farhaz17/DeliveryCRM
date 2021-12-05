<?php

namespace App\Http\ViewComposers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PermissionComposer
{
    public $user;
    public $userId;

    public function __construct()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $this->user=$user;
    }

    public function compose(View $view)
    {
        $viewData = [
            "user" => $this->user,
        ];
//        dd($viewData);
        $view->with($viewData);
    }
}