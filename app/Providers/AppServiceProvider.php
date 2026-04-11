<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('plus.navbar', function ($view) {
            $my_user = auth()->user();
            $count_notifications = 0;
            $notifications = [];
            $notifications_new = [];
            $notifications_old = [];
            if ($my_user) {
                $notifications = DB::table('notifications')
                    ->where('user_id', '=', $my_user->id)
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();
                $count_notifications = DB::table('notifications')
                    ->where('isRead', '=', false)
                    ->where('user_id', '=', $my_user->id)
                    ->count();
                $notifications_new = DB::table('notifications')
                    ->where('isRead', '=', false)
                    ->where('user_id', '=', $my_user->id)
                    ->get();
                $notifications_old = DB::table('notifications')
                    ->where('isRead', '=', true)
                    ->where('user_id', '=', $my_user->id)
                    ->get();
            }
            $view->with('my_user', $my_user)
                ->with('count_notifications', $count_notifications)
                ->with('notifications', $notifications)
                ->with('notifications_new', $notifications_new)
                ->with('notifications_old', $notifications_old);
        });
    }
}
