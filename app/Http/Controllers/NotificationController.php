<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    public function index()
    {
        // Code
    }

    public function notification_user()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $notifications = DB::table('notifications')
            ->where('user_id', '=', $my_user->id)->get();

        $notifications_new = DB::table('notifications')
            ->where('isRead', '=', false)
            ->where('user_id', '=', $my_user->id)->get();

        $notifications_old = DB::table('notifications')
            ->where('isRead', '=', true)
            ->where('user_id', '=', $my_user->id)->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.userPage.notification_user', [
            'my_user' => $my_user,
            'notifications' => $notifications,
            'notifications_new' => $notifications_new,
            'notifications_old' => $notifications_old,
            'settings_nav' => $settings_nav,
        ]);
    }

    public function notification_admin()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $notifications = DB::table('notifications')
            ->where('user_id', '=', $my_user->id)->get();

        $notifications_new = DB::table('notifications')
            ->where('isRead', '=', false)
            ->where('user_id', '=', $my_user->id)->get();

        $notifications_old = DB::table('notifications')
            ->where('isRead', '=', true)
            ->where('user_id', '=', $my_user->id)->get();

        $notifications = DB::table('notifications')
            ->where('isRead', '=', false)
            ->where('user_id', '=', $my_user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $count = count($notifications);

        if (count($notifications) == 0) {
            $notifications = DB::table('notifications')
                ->where('user_id', '=', $my_user->id)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();

            $count = 0;
        }

        return view('dashboard.index', [
            'my_user' => $my_user,
            'notifications' => $notifications,
            'count_notifications' => $count,
        ])
        ->with('title', 'Notification')
        ->with('main_content', 'dashboard.modules.notifications');
    }



    public function notification()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $notifications = DB::table('notifications')
            ->where('isRead', '=', false)
            ->where('user_id', '=', $my_user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $count = count($notifications);

        if (count($notifications) == 0) {
            $notifications = DB::table('notifications')
                ->where('user_id', '=', $my_user->id)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();

            $count = 0;
        }

        return view('plus.notifications', [
            'my_user' => $my_user,
            'notifications' => $notifications,
            'count_notifications' => $count,
        ]);
    }
}
