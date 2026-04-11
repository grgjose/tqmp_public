<?php

    namespace App\Http\Controllers;

    class ProductDetailsController extends Controller
    {
         public function index()
         {

          /** @var \Illuminate\Auth\SessionGuard $auth */
          $auth = auth();
          $my_user = $auth->user();

          return view("dashboard.product_details", [
               'my_user' => $my_user  
          ]);
         }
    }