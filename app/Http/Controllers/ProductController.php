<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\DatabaseImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
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
            ->where('products.deleted_at', '=', null)->get();

        $productImages = DB::table('product_images')->get();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'products' => $products,
            'product_images' => $productImages,
        ])
        ->with('title', 'Products')
        ->with('main_content', 'dashboard.settings.products');
    }

    /**
     * Show the cart of a User
     */
    public function before_add_to_cart($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        //$product = Product::Find($id);

        $product = Product::with([
            'variants.mappings.key',
            'variants.mappings.value'
        ])->findOrFail($id);
        
        $productImages = DB::table('product_images')->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        // Collect unique variant key/value pairs
        $variantOptions = [];
        $combinations = [];

        foreach ($product->variants as $variant) {
            $combination = [];
            foreach ($variant->mappings as $mapping) {
                $key = $mapping->key->key;
                $value = $mapping->value->value;

                $variantOptions[$key][] = $value;
                $combination[$key] = $value;
            }

            // Save the combination with metadata (sku, price, stock)
            $combinations[] = [
                'attributes' => $combination,
                'sku' => $variant->sku,
                'price' => $variant->price,
                'stock' => $variant->stock,
            ];
        }
        // Remove duplicate values
        foreach ($variantOptions as $key => $values) {
            $variantOptions[$key] = array_unique($values);
        }

        return view("home.userPage.product_details", [
            'my_user' => $my_user,
            'product' => $product,
            'variantOptions' => $variantOptions,
            'combinations' => $combinations,
            'productImages' => $productImages,
            'settings_nav' => $settings_nav,
        ]);
    }

    /**
     * Show the cart of a User
     */
    public function after_add_to_cart($id, Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $validated = $request->validate([
            'quantity' => ['required', 'min:1'],
            'price' => ['required', 'min:1'],
        ]);

        $checkItems = DB::table('carts')
        ->where('user_id', '=', $my_user->id)
        ->where('product_id', '=', $id)
        ->get();

        if(count($checkItems) > 0){

            $product = Product::Find($id);

            $cart = Cart::find($checkItems[0]->id);
            $cart->user_id = $my_user->id;
            $cart->product_id = $product->id;
            $cart->product_category_id = $product->category_id;
            $cart->quantity = $cart->quantity + intval($validated['quantity']);
            $cart->price = $product->price;
            $cart->discounted_price = $validated['price'];
            
            $cart->save();

        } else {
            $product = Product::Find($id);

            $cart = new Cart();
            $cart->user_id = $my_user->id;
            $cart->product_id = $product->id;
            $cart->product_category_id = $product->category_id;
            $cart->quantity = $validated['quantity'];
            $cart->price = $product->price;
            $cart->discounted_price = $validated['price'];
            
            $cart->remarks = "";
    
            $cart->save();
        }


        return redirect('/shop')->with('success_msg', 'Item Added to Cart');
    }

    /**
     * Show the cart of a User
     */
    public function cart()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $carts = DB::table('carts')->where('user_id', '=', $my_user->id)->get();
        $products = DB::table('products')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select('products.*', 'product_categories.category as category')
            ->where('products.deleted_at', '=', null)->get();

        $productImages = DB::table('product_images')->get();
        $shippings = DB::table('shippings')->where('user_id', '=', $my_user->id)->where('isDefault', '=', true)->get();

        $quotations = DB::table('quotations')
            ->leftJoin(DB::raw('(SELECT quotation_id, MIN(filename) as filename FROM quotation_images GROUP BY quotation_id) as qi'), 'quotations.id', '=', 'qi.quotation_id')
            ->select(
                'quotations.*', 
                'qi.filename as image')
            ->where('quotations.deleted_at', '=', null)->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');
            
        return view("home.userPage.cart", [
            'my_user' => $my_user,
            'carts' => $carts,
            'products' => $products,
            'shippings' => $shippings,
            'productImages' => $productImages,
            'quotations' => $quotations,
            'settings_nav' => $settings_nav,
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

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $productCategories = DB::table('product_categories')->get();
        $productSubCategories = DB::table('product_sub_categories')->get();

        return view('dashboard.settings.products-create', [
            'my_user' => $my_user,
            'productCategories' => $productCategories,
            'productSubCategories' => $productSubCategories,
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
       
       $validated = $request->validate([
           'name' => ['required', 'min:3'],
           'display_name' => ['required'],
           'description' => ['nullable'],
           'category_id' => ['required'],
           'sub_category_id' => ['required'],
           'brand' => ['nullable'],
           'price' => ['required'],
           'discounted_price' => ['required'],
           'special_discounted_price' => ['nullable'],
           'upload_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:4096'],
       ]);

       $filenames = array();

        // Handle file upload
        if ($request->hasFile('upload_files')) {
            foreach($request->file('upload_files') as $file){
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('all-items', $filename, 'public');
                array_push($filenames, $filename);
            }  
        } else {
            $filename = "default.png"; 
        }

        $product = new Product();
        $product->name = $validated['name'];
        $product->display_name = $validated['display_name'];
        $product->description = $validated['description'];
        $product->category_id = $validated['category_id'];
        $product->sub_category_id = $validated['sub_category_id'] == "null" ? null : $validated['sub_category_id'];
        $product->brand = $validated['brand'];
        $product->price = $validated['price'];
        $product->discounted_price = $validated['discounted_price'];
        $product->special_discounted_price = $validated['special_discounted_price'];
        $product->status = "active";
        $product->save();

        if(count($filenames) > 0){
            foreach($filenames as $name){
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->filename = $name;
                $productImage->save();
            }
        }

        $log = new Log();
        $log->user_id = $my_user->id ?? null;
        $log->action = 'Created product with id ' . $product->id;
        $log->details = 'Created product: ' . $product->name . ' ID: ' . $product->id . ' by user: ' . ($my_user->fname ?? 'Unknown') . ' ' . ($my_user->lname ?? 'User');
        $log->save();

        return redirect('/products')->with('success_msg', $product->name.' is Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if ($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $products = DB::table('products')->where('deleted_at', '=', null)->where('id', '=', $id)->get();
        $productCategories = DB::table('product_categories')->get();
        $productImages = DB::table('product_images')->get();

        if ($products == null) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');
        if (count($products) == 0) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        return view('dashboard.settings.products-view', [
            'my_user' => $my_user,
            'product' => $products[0],
            'productCategories' => $productCategories,
            'productImages' => $productImages,
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
        if ($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $products = DB::table('products')->where('deleted_at', '=', null)->where('id', '=', $id)->get();
        $productCategories = DB::table('product_categories')->get();
        $productSubCategories = DB::table('product_sub_categories')->get();
        $productImages = DB::table('product_images')->get();

        if ($products == null) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');
        if (count($products) == 0) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        return view('dashboard.settings.products-update', [
            'my_user' => $my_user,
            'product' => $products[0],
            'productCategories' => $productCategories,
            'productSubCategories' => $productSubCategories,
            'productImages' => $productImages,
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

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $product = Product::find($id);
        if($product == null) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        $validated = $request->validate([
            'name' => ['required', 'min:3'],
            'display_name' => ['required'],
            'description' => ['nullable'],
            'category_id' => ['required'],
            'sub_category_id' => ['required'],
            'brand' => ['nullable'],
            'price' => ['required'],
            'discounted_price' => ['required'],
            'special_discounted_price' => ['nullable'],
            'upload_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:4096'],
            'images_to_delete.*' => ['nullable'],
        ]);

        // Handle image deletion
        if ($request->has('images_to_delete')) {
            foreach ($validated['images_to_delete'] as $imageId) {
                // Find the image by its ID and delete it
                $image = ProductImage::find($imageId); // Assuming the product has a relationship with images
                if ($image) {
                    // Delete the image from the filesystem
                    if (file_exists(public_path('storage/all-items/' . $image->filename))) {
                        unlink(public_path('storage/all-items/' . $image->filename));
                    }
                    // Delete the image record from the database
                    $image->delete();
                }
            }
        }

        $filenames = array();

        // Handle file upload
        if ($request->hasFile('upload_files')) {
            foreach($request->file('upload_files') as $file){
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('all-items', $filename, 'public');
                array_push($filenames, $filename);
            }  
        } else {
            $filename = "default.png"; 
        }

        if(count($filenames) > 0){
            foreach($filenames as $name){
                $productImage = new ProductImage();
                $productImage->product_id = $id;
                $productImage->filename = $name;
                $productImage->save();
            }
        }

        // Capture original values before update
            $changes = [];

            if ($product->name != $validated['name']) {
                $changes[] = "name: '{$product->name}' -> '{$validated['name']}'";
            }

            if ($product->display_name != $validated['display_name']) {
                $changes[] = "display_name: '{$product->display_name}' -> '{$validated['display_name']}'";
            }

            if ($product->description != $validated['description']) {
                $changes[] = "description updated";
            }

            if ($product->category_id != $validated['category_id']) {
                $changes[] = "category_id: '{$product->category_id}' -> '{$validated['category_id']}'";
            }

            if ($product->brand != $validated['brand']) {
                $changes[] = "brand: '{$product->brand}' -> '{$validated['brand']}'";
            }

            if ($product->price != $validated['price']) {
                $changes[] = "price: '{$product->price}' -> '{$validated['price']}'";
            }

            if ($product->discounted_price != $validated['discounted_price']) {
                $changes[] = "discounted_price: '{$product->discounted_price}' -> '{$validated['discounted_price']}'";
            }

            if ($product->special_discounted_price != $validated['special_discounted_price']) {
                $changes[] = "special_discounted_price updated";
            }

            if ($request->has('images_to_delete')) {
                $changes[] = "images deleted";
            }

            if ($request->hasFile('upload_files')) {
                $changes[] = "new images uploaded";
            }
        //

        // Update product with new values
        $product->name = $validated['name'];
        $product->display_name = $validated['display_name'];
        $product->description = $validated['description'];
        $product->category_id = $validated['category_id'];
        $product->sub_category_id = $validated['sub_category_id'] == "null" ? null : $validated['sub_category_id'];
        $product->brand = $validated['brand'];
        $product->price = $validated['price'];
        $product->discounted_price = $validated['discounted_price'];
        $product->special_discounted_price = $validated['special_discounted_price'];

        $product->save();

        // Define what is updated in the log details
        $log = new Log();
        $log->user_id = $my_user->id ?? null;
        $log->action = 'Updated product with id ' . $product->id;
        $log->details = count($changes)
                        ? 'Updated product: '.$product->name.
                        ' | Changed: '.implode(', ', $changes).
                        ' | By user: '.($my_user->fname ?? 'Unknown').' '.($my_user->lname ?? 'User')
                        : 'Product opened for update but no fields changed.';
        $log->save();

        return redirect('/products')->with('success_msg', $product->name.' is Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect('/products')->with('success_msg', 'Product Successfully Deleted');
    }

    /**
     * Checkout Items of User
     *
     * Restructured to support multiple order items per order.
     * One Order (header) is created per checkout session.
     * One OrderItem (line) is created per selected cart row.
     */
    public function checkout(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();
 
        $validated = $request->validate([
            'checkboxes.*'  => ['required'],
            'reference_num' => ['required'],
            'paymentMethod' => ['required', 'in:onlinePayment,directTransfer'],
            'delivery'      => ['required', 'in:pickup,delivery'],
            'proof'         => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);
 
        // ── GATE 1: Coupon code must not be entered ──────────────────────────
        if ($request->filled('coupon_code')) {
            return redirect('/cart')->with('error_msg', 'Coupon is Expired or Not Available.');
        }
 
        // ── GATE 2: Delivery requires a default shipping address ─────────────
        if ($validated['delivery'] === 'delivery') {
            $hasShipping = \App\Models\Shipping::where('user_id', $my_user->id)
                                               ->where('isDefault', true)
                                               ->exists();
            if (!$hasShipping) {
                return redirect('/cart')->with('error_msg', 'Please set a default shipping address before selecting Delivery.');
            }
        }
 
        // ── GATE 3: Check for expired quotation items in selected cart rows ──
        foreach ($validated['checkboxes'] as $cartId) {
            $cart = \App\Models\Cart::find($cartId);
            if ($cart && $cart->quotation_id) {
                $quotation = \App\Models\Quotation::find($cart->quotation_id);
                if ($quotation && $quotation->valid_until && \Carbon\Carbon::now()->greaterThan($quotation->valid_until)) {
                    \App\Models\Quotation::withoutEvents(function () use ($quotation) {
                        $quotation->status = 'Expired';
                        $quotation->save();
                    });
                    $cart->delete();
                    return redirect('/cart')->with('error_msg', 'One or more quotation items have expired and have been removed. Please review your cart.');
                }
            }
        }
 
        // ── GATE 4: Pre-validate stock for all product items before writing ──
        // Check all items first so we never partially commit an order.
        foreach ($validated['checkboxes'] as $cartId) {
            $cart = Cart::find($cartId);
            if ($cart && $cart->product_id) {
                $requestedQty = intval($request->input('quantity_' . $cartId));
                $inventory = DB::table('inventories')->where('product_id', $cart->product_id)->first();
                if (!$inventory) {
                    return redirect('/cart')->with('error_msg', 'Inventory not found for product: ' . $cart->product_id);
                }
                if (($inventory->stock - $requestedQty) < 0) {
                    return redirect('/cart')->with('error_msg', 'Insufficient stock for product: ' . $cart->product_id);
                }
            }
        }
 
        // ── Handle proof of payment file upload (once for the whole order) ───
        $filename = null;
        if ($request->hasFile('proof')) {
            $file     = $request->file('proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('proof', $filename, 'public');
        }
 
        // ── Resolve shipping address ─────────────────────────────────────────
        $shippingAddress = $my_user->address;
        if ($validated['delivery'] === 'delivery') {
            $defaultShipping = \App\Models\Shipping::where('user_id', $my_user->id)
                                                   ->where('isDefault', true)
                                                   ->first();
            if ($defaultShipping) {
                $shippingAddress = $defaultShipping->fulladdress ?? $defaultShipping->address;
            }
        }
 
        // ── Create ONE Order header for the entire checkout session ──────────
        $referenceNum = 'SQ-' . $validated['reference_num'];
 
        $order                   = new Order();
        $order->reference_num    = $referenceNum;
        $order->customer_id      = $my_user->id;
        $order->sales_rep_id     = 0;
        $order->shipping_address = $shippingAddress;
        $order->delivery_type    = $validated['delivery'];
        $order->proof_of_payment = $filename;
        $order->status           = 'Verifying Payment';
        $order->save();
 
        // ── Create one OrderItem per selected cart row ───────────────────────
        foreach ($validated['checkboxes'] as $cartId) {
            $cart = Cart::find($cartId);
 
            if (!$cart) continue;
 
            // Deduct inventory for product items
            if ($cart->product_id) {
                $requestedQty = intval($request->input('quantity_' . $cartId));
                DB::table('inventories')
                  ->where('product_id', $cart->product_id)
                  ->decrement('stock', $requestedQty);
            }
 
            // Create the order line item
            $item               = new \App\Models\OrderItem();
            $item->order_id     = $order->id;
            $item->product_id   = $cart->product_id;
            $item->quotation_id = $cart->quotation_id;
            $item->quantity     = intval($request->input('quantity_' . $cartId, $cart->quantity));
            $item->unit_price   = floatval($cart->price);
            $item->discounted_price = $cart->discounted_price
                                        ? floatval($request->input('price_' . $cartId, $cart->discounted_price))
                                        : null;
            $item->status       = 'Pending';
            $item->save();
 
            // Remove from cart
            $cart->delete();
        }
 
        // ── Save computed total back to the order header ─────────────────────
        $order->total_amount = $order->computeTotal();
        $order->save();
 
        // ── Prepare email data ───────────────────────────────────────────────
        $orderWithItems = \App\Models\Order::with([
            'items.product',
            'items.quotation',
        ])->where('reference_num', $referenceNum)->first();
 
        $data = [
            'order'         => $orderWithItems,
            'items'         => $orderWithItems->items,
            'user'          => $my_user,
            'reference_num' => $referenceNum,
            'date'          => date('Y-m-d'),
        ];
 
        $mailTo = env('CHECKOUT_MAIL_TO');
        $mailCc = env('CHECKOUT_MAIL_CC');
 
        Mail::to($mailTo)->cc($mailCc)->send(new OrderPlacedMail($data));
 
        // ── Fix P-023: redirect with reference number ────────────────────────
        return redirect('/order-status/' . $referenceNum)
               ->with('success_msg', 'Checkout Successful! Here is your order status.');
    }

    /**
     * Order Status
     */
    public function order_status($reference)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        // $orders = DB::table('orders')
        // ->join('products', 'orders.product_id', '=', 'products.id')
        // ->select('orders.*', 'products.name as name')
        // ->where('orders.reference_num', '=', $reference)
        // ->get();

        $orders = DB::table('orders')
            ->leftJoin('products', 'products.id', '=', 'orders.product_id')
            ->leftJoin('quotations', 'quotations.id', '=', 'orders.quotation_id')
            ->select(
                'orders.*',
                'products.name as product_name',
                'quotations.reference as quotation_reference'
            )
            ->where('orders.reference_num', '=', $reference)
            ->where('orders.customer_id', '=', $my_user->id)  // security: only show own orders
            ->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.userPage.order_status', [
            'my_user' => $my_user,
            'orders' => $orders,
            'settings_nav' => $settings_nav,
        ]);
    }

    /**
     * Remove Item from Cart
     */
    public function remove($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.',
            ], 404);
        }
    
        $cart->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'user' => $my_user, // Optional — only if needed on the frontend
        ]);
    }

    /**
     * Testing Import
     */
    public function import()
    {
        // Build full path to the file
        $path = storage_path('app\public\imports\DatabaseSeeder.xlsx');
        $importer = new DatabaseImport();
        Excel::import($importer, $path);

        $data = $importer->getData();
        $usertypes = $data['Usertypes'];
        $users = $data['Users'];
        $categories = $data['Categories'];
        $products = $data['Products'];

        dd($users);
    }

}
