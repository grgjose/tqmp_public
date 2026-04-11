<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class CheckNotification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        // Check if the user is authenticated
        if($my_user == null) {
            return redirect('/home')->with('error_msg', 'Login First');
        }

        $path = '/home'.$request->path();

        // Check if the user has notifications
        $notifications = DB::table('notifications')->where('user_id', $my_user->id)
            ->where('isRead', false)
            ->where('link', '=', $path)
            ->get();

        foreach ($notifications as $notification) {
            // Mark the notification as read
            $notif = Notification::find($notification->id);
            if ($notif) {
                $notif->isRead = true;
                $notif->save();
            }
        }

        // Proceed with the request
        return $next($request);
    }
}
