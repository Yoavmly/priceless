<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //


    public function getNotifications(Request $request) {

        $user = $request->user();

        $notifications = $user->unreadNotifications->take(5);

        return response($notifications,200);
    }

    public function readNotifications(Request $request) {

        $user =  $request->user();


    }
}
