<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductSubCategory;

class ProductCategoryController extends Controller
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

        $productCategories = DB::table('product_categories')
            ->where('isDeleted', '=', false)->get();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'title' => 'Product Categories',
            'main_content' => 'dashboard.settings.product-categories',
            'productCategories' => $productCategories,
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

        $productCategories = DB::table('product_categories')
            ->where('isDeleted', '=', false)->get();

        if($productCategories == null || count($productCategories) == 0){
            return redirect('/product-categories')->with('error_msg', 'Unexpected Error!');
        }
            
        return view('dashboard.settings.product-categories-create', [
            'my_user' => $my_user
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
            'category' => ['required', 'min:1'],
            'description' => ['required'],
        ]);

        $productsCategory = new ProductCategory();
        $productsCategory->category = $validated['category'];
        $productsCategory->description = $validated['description'];
        $productsCategory->save();

        return redirect('/product-categories')->with('success_msg', 'Product Category Successfully Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $subCategories = DB::table('product_sub_categories')
            ->where('category_id', '=', $id)
            ->where('isDeleted', '=', false)->get();
        
        return view('dashboard.settings.product-categories-view', [
            'subCategories' => $subCategories,
            'category_id' => $id,
        ]);
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

        $productCategories = DB::table('product_categories')
            ->where('id', '=', $id)
            ->where('isDeleted', '=', false)->get();

        if($productCategories == null || count($productCategories) == 0){
            return redirect('/product-categories')->with('error_msg', 'Unexpected Error!');
        }

        return view('dashboard.settings.product-categories-update', [
            'my_user' => $my_user,
            'productCategories' => $productCategories[0],
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
            'category' => ['required', 'min:1'],
            'description' => ['required'],
        ]);

        $productsCategory = ProductCategory::find($id);
        $productsCategory->category = $validated['category'];
        $productsCategory->description = $validated['description'];
        $productsCategory->updated_at = date('Y-m-d');
        $productsCategory->save();

        return redirect('/product-categories')->with('success_msg', 'Product Category Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $products = DB::table('products')->where('category_id', '=', $id)->where('isDeleted', '=', false)->get();
        
        if($products != null || count($products) > 0){
            return redirect('/product-categories')->with('error_msg', 'Product Category is currently being used hence cannot be deleted.');
        }

        $productsCategory = ProductCategory::find($id);
        $productsCategory->isDeleted = true;
        $productsCategory->save();

        return redirect('/product-categories')->with('success_msg', 'Product Category Successfully Deleted');
    }

    public function subCategoryStore(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if ($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $validated = $request->validate([
            'category_id' => ['required'],
            'category' => ['required', 'min:1'],
            'description' => ['nullable'],
        ]);

        $sub_category = new ProductSubCategory();
        $sub_category->category_id = $validated['category_id'];
        $sub_category->category = $validated['category'];
        $sub_category->description = $validated['description'] ?? '';
        $sub_category->save();

        return redirect('/product-categories')->with('clickThis', 'button'.$sub_category->category_id)->with('success_msg', 'Product Sub-Category Successfully Created');
    }

    public function subCategoryUpdate($id, Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if ($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $validated = $request->validate([
            'category' => ['required', 'min:1'],
            'description' => ['nullable'],
        ]);

        $sub_category = ProductSubCategory::find($id);
        $sub_category->category = $validated['category'];
        $sub_category->description = $validated['description'] ?? '';
        $sub_category->updated_at = date('Y-m-d');
        $sub_category->save();

        return redirect('/product-categories')->with('clickThis', 'button'.$sub_category->category_id)->with('success_msg', 'Product Sub-Category Successfully Updated');   
    }

    public function subCategoryDestroy($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if ($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $products = DB::table('products')->where('sub_category_id', '=', $id)->where('isDeleted', '=', false)->get();

        if(count($products) > 0){
            return redirect('/product-categories')->with('error_msg', 'Product Sub-Category is currently being used hence cannot be deleted.');
        }

        $sub_category = ProductSubCategory::find($id);
        $sub_category->isDeleted = true;
        $sub_category->save();

        return redirect('/product-categories')->with('clickThis', 'button'.$sub_category->category_id)->with('success_msg', 'Product Sub-Category Successfully Deleted');   
    }
}
