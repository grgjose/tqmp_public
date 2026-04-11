<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null){
            return redirect('/home')->with('error_msg', 'Invalid Access!');
        }

        if($my_user->usertype > 2){
            return redirect('/home')->with('error_msg', 'Invalid Access!');
        }

        $newOrders = DB::table('orders')->where('created_at', '>=', now()->subDays(7))->count();
        $newQuotes = DB::table('quotations')->where('created_at', '>=', now()->subDays(7))->count();
        $newUsers = DB::table('users')->where('created_at', '>=', now()->subDays(7))->count();

        // Get New Sales
        // Assuming you have a sales table and want to count new sales in the last 7 days
        // Adjust the table name and column as per your database schema
        // Sum of price of new sales in the last 7 days
        $newSales = DB::table('orders')->where('created_at', '>=', now()->subDays(7))->sum('price');


        return view('dashboard.index', [
            'my_user' => $my_user,
            'newOrders' => $newOrders,
            'newQuotes' => $newQuotes,
            'newUsers' => $newUsers,
            'newSales' => $newSales,
        ])
        ->with('title', 'Dashboard')
        ->with('main_content', 'dashboard.modules.dashboard');
    
    }

}
