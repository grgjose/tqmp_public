<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if ($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $products = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->select('products.*', 'product_categories.category as category')
        ->where('products.isDeleted', '=', false)->get();

        $productVariants = DB::table('product_variants')
            ->where('isDeleted', '=', false)->get();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'title' => 'Product Variants',
            'main_content' => 'dashboard.settings.product-variants-table',
            'products' => $products,
            'productVariants' => $productVariants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if ($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $products = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->select('products.*', 'product_categories.category as category')
        ->where('products.isDeleted', '=', false)->get();

        if($products == null || count($products) == 0){
            return redirect('/product-variants')->with('error_msg', 'Unexpected Error!');
        }
            
        return view('dashboard.settings.product-variants-create', [
            'my_user' => $my_user,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if ($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $validated = $request->validate([
            'product_id' => ['required'],
            'key' => ['required', 'min:1'],
            'value' => ['required'],
        ]);

        $productVariant = new ProductVariant();
        $productVariant->product_id = $validated['product_id'];
        $productVariant->key = $validated['key'];
        $productVariant->value = $validated['value'];
        $productVariant->save();

        return redirect('/product-variants')->with('success_msg', 'Product Variant Successfully Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if ($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $products = DB::table('products')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->select('products.*', 'product_categories.category as category')
        ->where('products.isDeleted', '=', false)->get();

        $productVariants = DB::table('product_variants')
            ->where('id', '=', $id)
            ->where('isDeleted', '=', false)->get();

        if($products == null || count($products) == 0){
            return redirect('/product-variants')->with('error_msg', 'Unexpected Error!');
        }

        if($productVariants == null || count($productVariants) == 0){
            return redirect('/product-variants')->with('error_msg', 'Unexpected Error!');
        }
            
        return view('dashboard.settings.product-variants-update', [
            'my_user' => $my_user,
            'products' => $products,
            'productVariants' => $productVariants[0],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if ($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $validated = $request->validate([
            'product_id' => ['required'],
            'key' => ['required', 'min:1'],
            'value' => ['required'],
        ]);

        $productVariant = ProductVariant::find($id);
        $productVariant->product_id = $validated['product_id'];
        $productVariant->key = $validated['key'];
        $productVariant->value = $validated['value'];
        $productVariant->updated_at = date('Y-m-d');
        $productVariant->save();

        return redirect('/product-variants')->with('success_msg', 'Product Variants Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $productVariant = ProductVariant::find($id);
        $productVariant->isDeleted = true;
        $productVariant->save();

        return redirect('/product-variants')->with('success_msg', 'Product Category Successfully Deleted');
    }
}
