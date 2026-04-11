<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesAuth
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

        // Check if the user has the required permissions
        if ($my_user->usertype != 2 && $my_user->usertype != 1) {
            return redirect('/home')->with('error_msg', 'You do not have permission to access this page');
        }

        return $next($request);
    }
}
