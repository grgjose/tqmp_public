<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenTradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $products = DB::table('products')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->leftJoin('product_sub_categories', 'products.sub_category_id', '=', 'product_sub_categories.id')
            ->leftJoin(DB::raw('(SELECT product_id, MIN(filename) as filename FROM product_images GROUP BY product_id) as pi'), 'products.id', '=', 'pi.product_id')
            ->select(
                'products.*', 
                'product_categories.category as category',
                'product_sub_categories.category as sub_category',
                'pi.filename as image')
            ->where('products.isDeleted', '=', false)->get();


        $productSubCategories = DB::table('product_sub_categories')
        ->leftJoin('products', 'products.sub_category_id', '=', 'product_sub_categories.id')
        ->select('product_sub_categories.id', 'product_sub_categories.category_id', 'product_sub_categories.description', 'product_sub_categories.category', DB::raw('COUNT(products.id) as product_count'))
        ->groupBy('product_sub_categories.id', 'product_sub_categories.category_id', 'product_sub_categories.description', 'product_sub_categories.category')
        ->get();

        $productImages = DB::table('product_images')->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.home.gentrade.index', [
            'my_user' => $my_user,
            'products' => $products,
            'productSubCategories' => $productSubCategories,
            'productImages' => $productImages,
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
