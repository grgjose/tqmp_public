<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BulletProofingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();
        
        $settings = DB::table('settings')->where('key', 'like', 'BULLET_%')->pluck('value', 'key');
        $settings_raw = DB::table('settings')->where('key', 'like', 'BULLET_%')->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        $products = DB::table('products')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->select('products.*', 'product_categories.category as category', 'product_images.filename as filename')
            ->where('product_categories.category', '=', 'Bullet Proofing')
            ->where('products.deleted_at', '=', null)->get();

        return view('home.home.bulletproofing.index', [
            'my_user' => $my_user,
            'settings' => $settings,
            'products' => $products,
            'settings_nav' => $settings_nav,
        ]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
