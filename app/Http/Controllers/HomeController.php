<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Shipping;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    //

    public function index()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $settings = DB::table('settings')->where('key', 'like', 'WELCOME_%')->pluck('value', 'key');
        $settings_raw = DB::table('settings')->where('key', 'like', 'WELCOME_%')->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.home.index', [
            'my_user' => $my_user,
            'settings' => $settings,
            'settings_raw' => $settings_raw,
            'settings_nav' => $settings_nav,
        ]);
    }

    public function home()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $settings = DB::table('settings')->where('key', 'like', 'HOME_%')->pluck('value', 'key');
        $settings_raw = DB::table('settings')->where('key', 'like', 'HOME_%')->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.home.home', [
            'my_user' => $my_user,
            'settings' => $settings,
            'settings_nav' => $settings_nav,
        ]);
    }

    public function about()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $settings = DB::table('settings')->where('key', 'like', 'ABOUT_US_%')->pluck('value', 'key');
        $settings_raw = DB::table('settings')->where('key', 'like', 'ABOUT_US_%')->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.home.about', [
            'my_user' => $my_user,
            'settings' => $settings,
            'settings_raw' => $settings_raw,
            'settings_nav' => $settings_nav,
        ]);
    }

    public function contact()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $settings = DB::table('settings')->where('key', 'like', 'CONTACT_%')->pluck('value', 'key');
        $settings_raw = DB::table('settings')->where('key', 'like', 'CONTACT_%')->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.home.contact', [
            'my_user' => $my_user,
            'settings' => $settings,
            'settings_raw' => $settings_raw,
            'settings_nav' => $settings_nav,
        ]);
    }

    public function faqs()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.home.faqs', [
            'my_user' => $my_user,
        ]);
    }

    public function services()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.home.services', [
            'my_user' => $my_user,
        ]);
    }

    public function profile()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) {
            return redirect('/home')->with('error_msg', 'Login First to view profile');
        }

        $quotations = DB::table('quotations')->where('user_id', '=', $my_user->id)->get();

        $groupedOrders = DB::table('orders')
            ->select(
                'reference_num',
                DB::raw("
                CASE 
                    WHEN SUM(CASE WHEN status != 'completed' THEN 1 ELSE 0 END) = 0 
                    THEN 'completed' 
                    ELSE 'pending' 
                END as group_status
            "),
                DB::raw('SUM(price) as total_price'),
                DB::raw('MIN(created_at) as nearest_created_at')
            )
            ->groupBy('reference_num')
            ->get();

        $shippings = DB::table('shippings')
            ->where('user_id', $my_user->id)
            ->get();

        $orders = DB::table('orders')->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*', 'products.display_name AS display_name')
            ->where('orders.customer_id', $my_user->id)->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.userPage.profile', [
            'my_user' => $my_user,
            'shippings' => $shippings,
            'quotations' => $quotations,
            'groupedOrders' => $groupedOrders,
            'orders' => $orders,
            'settings_nav' => $settings_nav,
        ]);
    }

    public function saveProfile(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $validated = $request->validate([
            'username' => ['required', 'min:3'],
            'fname' => ['required', 'min:3'],
            'mname' => ['nullable', 'min:3'],
            'lname' => ['required', 'min:3'],
            'ext' => ['nullable', 'min:3'],
            'birthdate' => ['nullable'],
            'address' => ['nullable', 'min:3'],
            'email' => ['required', 'email'],
            'contact_number' => ['nullable', 'regex:/^(09|\+639)\d{9}$/'],
            'new_password' => ['nullable', 'min:8'],
            'profile_pic' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('user-pics', $filename, 'public');

            // Update profile picture path
            $my_user->user_pic = $filename;
        }

        // Update user profile
        $my_user->username = $validated['username'];
        $my_user->fname = $validated['fname'];
        $my_user->mname = $validated['mname'];
        $my_user->lname = $validated['lname'];
        $my_user->ext = $validated['ext'];
        $my_user->email = $validated['email'];
        $my_user->contact_num = $validated['contact_number'];
        $my_user->birthdate = $validated['birthdate'];
        $my_user->address = $validated['address'];

        // Update password if provided
        if ($validated['new_password'] != null && $validated['new_password'] != '') {
            $my_user->password = Hash::make($validated['new_password']);
        }

        // Save the updated user
        $my_user->save();

        // Update session user
        auth()->setUser($my_user);

        // Redirect with success message
        if ($my_user->usertype == 3) {
            return redirect('/profile')->with('success_msg', 'Profile Updated');
        }

        // If user is admin, redirect to admin dashboard
        if ($my_user->usertype < 3) {
            return redirect('/admin/dashboard')->with('success_msg', 'Profile Updated');
        }

        return redirect('/profile')->with('success_msg', 'Profile Updated');
    }

    public function setShippingProfile()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();
        $apiKey = env('GOOGLE_API_KEY');
        $hostname = env('APP_URL');
        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        if ($my_user == null) {
            return redirect('/home')->with('error_msg', 'Login First to set shipping address');
        }

        return view('home.userPage.profile_shipping', [
            'my_user' => $my_user,
            'apiKey' => $apiKey,
            'hostname' => $hostname,
            'settings_nav' => $settings_nav,
        ]);
    }

    public function saveShipping(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $validated = $request->validate([
            'fulladdress' => ['required', 'min:3'],
            'address' => ['required', 'min:3'],
            'lat' => ['required', 'min:3'],
            'lng' => ['required', 'min:3'],
            'delivery_fee' => ['required', 'min:3'],
            'fullname' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'contact_num' => ['required', 'regex:/^(09|\+639)\d{9}$/'],
            'isDefault' => ['nullable'],
        ]);

        $shipping = new Shipping();
        $shipping->user_id = $my_user->id;
        $shipping->fulladdress = $validated['fulladdress'];
        $shipping->fullname = $validated['fullname'];
        $shipping->email = $validated['email'];
        $shipping->contact_num = $validated['contact_num'];
        $shipping->address = $validated['address'];
        $shipping->lat = $validated['lat'];
        $shipping->lng = $validated['lng'];
        $shipping->delivery_fee = $validated['delivery_fee'];

        // Check if this shipping address should be set as default
        if ($validated['isDefault']) {
            // Remove existing default shipping address for the user
            Shipping::where('user_id', $my_user->id)->update(['isDefault' => false]);
        } else {
            // If all shipping addresses are not set as default, we can set this one as default
            $existingDefault = Shipping::where('user_id', $my_user->id)->where('isDefault', true)->first();
            if (!$existingDefault) {
                $validated['isDefault'] = true; // Set this as default if no other default exists
            }
        }
        $shipping->isDefault = $validated['isDefault'] == "on" ? true : false;
        $shipping->save();

        return redirect('/profile')->with('success_msg', 'Shipping Address Saved');
    }

    public function shop()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) {
            return redirect('/home')->with('error_msg', 'Login First to avail shopping');
        }

        $products = DB::table('products')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->leftJoin('product_sub_categories', 'products.sub_category_id', '=', 'product_sub_categories.id')
            ->leftJoin(DB::raw('(SELECT product_id, MIN(filename) as filename FROM product_images GROUP BY product_id) as pi'), 'products.id', '=', 'pi.product_id')
            ->select(
                'products.*',
                'product_categories.category as category',
                'product_sub_categories.category as sub_category',
                'pi.filename as image'
            )
            ->where('products.deleted_at', '=', null)->get();

        $productSubCategories = DB::table('product_sub_categories')->get();

        $productCategories = DB::table('product_categories')->get(); // ADD THIS LINE

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.userPage.shop', [
            'my_user' => $my_user,
            'products' => $products,
            'productSubCategories' => $productSubCategories,
            'productCategories' => $productCategories, // ADD THIS LINE
            'settings_nav' => $settings_nav,
        ]);
    }

    public function addInquiry(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $validated = $request->validate([
            'fullname' => ['required', 'min:3'],
            'email' => ['required'],
            'contact_num' => ['required'],
            'subject' => ['required'],
            'message' => ['required'],
            'upload_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        // Handle file upload
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('inquiries', $filename, 'public');
        } else {
            $filename = "default.png";
        }

        $inquiry = new Inquiry();
        $inquiry->fullname = $validated['fullname'];
        $inquiry->email = $validated['email'];
        $inquiry->contact_num = $validated['contact_num'];
        $inquiry->subject = $validated['subject'];
        $inquiry->message = $validated['message'];
        $inquiry->upload_file = $filename;
        $inquiry->save();

        return redirect('/contact')->with('success_msg', 'Inquiry Submitted');
    }

    /**
     * Order Status  of User
     *
     * Restructured to support multiple order items per order.
     * One Order (header) is created per checkout session.
     * One OrderItem (line) is created per selected cart row.
     */
    public function OrderStatus()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();
 
        if ($my_user == null || $my_user->usertype < 3) {
            return redirect('/home')->with('error_msg', 'Login First to view status');
        }
 
        // Quotations for this user
        $quotations = DB::table('quotations')
            ->where('user_id', $my_user->id)
            ->get();
 
        // All orders for this user, with item counts and total
        $orders = \App\Models\Order::with('items')
            ->where('customer_id', $my_user->id)
            ->latest()
            ->get();
 
        $settings_nav = DB::table('settings')
            ->where('key', 'like', 'NAVBAR_%')
            ->pluck('value', 'key');
 
        return view('home.status.OrderStatus', [
            'my_user'      => $my_user,
            'quotations'   => $quotations,
            'orders'       => $orders,
            'settings_nav' => $settings_nav,
        ]);
    }

    public function QuoteStatus()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null || $my_user->usertype < 3) {
            return redirect('/home')->with('error_msg', 'Login First to view status');
        }

        // Fetch quotations and orders for the user
        $quotations = DB::table('quotations')->where('user_id', '=', $my_user->id)->get();

        $groupedOrders = DB::table('orders')
            ->select(
                'reference_num',
                DB::raw("
                CASE 
                    WHEN SUM(CASE WHEN status != 'completed' THEN 1 ELSE 0 END) = 0 
                    THEN 'completed' 
                    ELSE 'pending' 
                END as group_status
            "),
                DB::raw('SUM(price) as total_price'),
                DB::raw('MIN(created_at) as nearest_created_at')
            )
            ->groupBy('reference_num')
            ->get();

        $orders = DB::table('orders')->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*', 'products.display_name AS display_name')
            ->where('orders.customer_id', $my_user->id)->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.status.QuoteStatus', [
            'my_user' => $my_user,
            'quotations' => $quotations,
            'groupedOrders' => $groupedOrders,
            'orders' => $orders,
            'settings_nav' => $settings_nav,
        ]);
    }

    public function number()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.home.sms.number', [
            'my_user' => $my_user,
        ]);
    }

    public function otp()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.home.sms.otp', [
            'my_user' => $my_user,
        ]);
    }

    public function success()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.home.sms.success', [
            'my_user' => $my_user,
        ]);
    }

        public function unsuccessful()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view('home.home.sms.unsuccessful', [
            'my_user' => $my_user,
        ]);
    }
}
