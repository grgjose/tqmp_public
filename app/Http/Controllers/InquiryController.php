<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        //$users = DB::table('users')->where('isDeleted', '=', false)->get();

        $inquiries = DB::table('inquiries')
        ->where('deleted_at', '=', null)
        ->get();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'inquiries' => $inquiries,
        ])
        ->with('title', 'Inquiries')
        ->with('main_content', 'dashboard.modules.inquiries');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        //$users = DB::table('users')->where('isDeleted', '=', false)->get();

        $inquiries = DB::table('inquiries')
        ->where('id', '=', $id)
        ->where('deleted_at', '=', null)
        ->get();

        return view('dashboard.modules.inquiries-view', [
            'my_user' => $my_user,
            'inquiry' => $inquiries[0],
        ])
        ->with('title', 'Inquiries');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inquiry $inquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inquiry $inquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        //
    }
}
