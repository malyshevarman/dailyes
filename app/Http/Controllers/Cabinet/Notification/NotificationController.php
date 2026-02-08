<?php

namespace App\Http\Controllers\Cabinet\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = \Auth::user();
        $data = $user->notifications()->paginate(10);
        $user->unreadNotifications()->update(['read_at' => now()]);



        return view('cabinet.notification.index')
            ->withNotifications($data);
    }
}
