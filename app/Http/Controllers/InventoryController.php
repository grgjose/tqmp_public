<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;

class InventoryController extends Controller
{
    /**
     * Default Function
     */
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

        $inventories = DB::table('inventories')
        ->join('products', 'products.id', '=', 'inventories.product_id')
        ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
        ->join('product_sub_categories', 'product_sub_categories.id', '=', 'products.sub_category_id')
        ->select(
            'inventories.*',
            'products.name as product_name',
            'products.price as product_price',
            'products.display_name as product_display_name',
            'products.category_id as category_id',
            'products.sub_category_id as sub_category_id',
        )
        ->get();

        $users = DB::table('users')->where('usertype', '=', 3)->get();

        // return view('dashboard.inventory', [
        //     'my_user' => $my_user,
        // ]);
        
        return view('dashboard.index', [
            'my_user' => $my_user,
            'inventories' => $inventories,
            'users' => $users,
        ])
        ->with('title', 'Inventory')
        ->with('main_content', 'dashboard.modules.inventory');

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype == 3) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $inventory = Inventory::find($id);
        if(!$inventory) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        $validated = $request->validate([
            'stock' => ['required'],
            'status' => ['required'],
        ]);

        $inventory->stock = $validated['stock'];
        $inventory->status = $validated['status'];
        $inventory->save();

        return redirect('/inventory')->with('success_msg', $inventory->name.' is Updated');
    }

}
