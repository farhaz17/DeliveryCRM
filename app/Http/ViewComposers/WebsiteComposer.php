<?php

namespace App\Http\ViewComposers;

use App\Model\InvParts;
use App\Model\Notification;
use App\Model\VisaProcess\VisaCancelChat;
use Illuminate\View\View;

class WebsiteComposer
{
//    public $inventory_items;
    public $notification;
    public $notification2;
    public $notification3;
    public $visa_chat;

    public function __construct()
    {
//        $inventory_items = InvParts::where('quantity_balance','<=', 5)->get();
//        $this->inventory_items=$inventory_items;


        $notification= auth()->user()->unreadNotifications;
        $this->notification=$notification;



        $notification2= auth()->user()->unreadNotifications_visa;
        $this->notification2=$notification2;

        $chatData= VisaCancelChat::get();
        $this->chatData=$chatData;

        $notification3= auth()->user()->unreadNotifications_parts;
        $this->notification3=$notification3;





    }

    public function compose(View $view)
    {
//        $viewData = [
//            "invItems" => $this->inventory_items,
//        ];
////        dd($viewData);
//        $view->with($viewData);

        $viewData = [
            "notification" => $this->notification,
            "notification2" => $this->notification2,
            "notification3" => $this->notification3,
            "chatData" => $this->chatData,
        ];
//        dd($viewData);
        $view->with($viewData);
    }
}
