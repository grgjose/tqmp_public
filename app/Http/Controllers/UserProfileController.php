<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\QuotationImage;
use App\Models\QuotationMessage;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    public function index()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.userprofiles', [
            'my_user' => $my_user,
        ]);
    }


    public function quotation_bulletproof()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.quotation.bulletproof', [
            'my_user' => $my_user,
        ]);
    }

    public function quotation_glasspro()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.quotation.glasspro', [
            'my_user' => $my_user,
        ]);
    }

    public function process_order()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.process_order', [
            'my_user' => $my_user,
        ]);
    }

    public function messages()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('dashboard.messages', [
            'my_user' => $my_user,
        ]);
    }

    public function user_messages($reference = '000001-3')
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $quotation = DB::table('quotations')->where('reference', '=', $reference)->get();
        if ($quotation == null || count($quotation) == 0) {
            return redirect('/profile')->with('error_msg', 'Invalid Quotation');
        }

        $quotationMessages = DB::table('quotation_messages')
            ->join('users', 'quotation_messages.from_user_id', '=', 'users.id')
            ->select('quotation_messages.*', 'users.usertype as usertype', 'users.fname as fname', 'users.lname as lname')
            ->where('quotation_messages.quotation_id', '=', $quotation[0]->id)
            ->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.user_messages', [
            'my_user' => $my_user,
            'quotation' => $quotation[0],
            'quotationMessages' => $quotationMessages,
            'settings_nav' => $settings_nav,
        ]);
    }

    public function order_status()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('dashboard.order_status', [
            'my_user' => $my_user,
        ]);
    }

    public function hidden_store()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.hidden_store', [
            'my_user' => $my_user,
        ]);
    }

    public function main_quote()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.main_quote', [
            'my_user' => $my_user,
        ]);
    }

    public function quote_msg()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.quotation.quote_msg', [
            'my_user' => $my_user,
        ]);
    }

    public function shipping()
    {
         /** @var \Illuminate\Auth\SessionGuard $auth */
         $auth = auth();
         $my_user = $auth->user();
         $apiKey = env('GOOGLE_API_KEY');
         $hostname = env('APP_URL');
 
 
         return view('home.shipping', [
             'my_user' => $my_user,
             'apiKey' => $apiKey,
             'hostname' => $hostname,
         ]);
    }

    public function receipt()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.receipt', [
            'my_user' => $my_user,
        ]);
    }

        public function adminprofile()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('dashboard.profile', [
            'my_user' => $my_user,
        ])
        ->with('title', 'Profile')
        ;
    }

   
  

    
}
