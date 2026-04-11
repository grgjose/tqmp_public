<?php

namespace App\Http\Controllers;


class CheckoutController extends Controller
{
    public function index()
    {
          /** @var \Illuminate\Auth\SessionGuard $auth */
          $auth = auth();
          $my_user = $auth->user();

          return view("dashboard.checkout", [
               'my_user' => $my_user,
               
          ]);
    }
}


