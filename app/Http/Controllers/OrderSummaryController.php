<?php

    namespace App\Http\Controllers;


    class OrderSummaryController extends Controller
    {
         public function index()
         {
          /** @var \Illuminate\Auth\SessionGuard $auth */
          $auth = auth();
          $my_user = $auth->user();

          return view("dashboard.ordersummary", [
               'my_user' => $my_user  
          ]);
         }
    }