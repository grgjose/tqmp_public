<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsumerController extends Controller
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

        //return view('dashboard.consumer');

        
        return view('dashboard.index', [
            'my_user' => $my_user,
        ])
        ->with('title', 'Consumers')
        ->with('main_content', 'dashboard.modules.consumer');
    }
}
