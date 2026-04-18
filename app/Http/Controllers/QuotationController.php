<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\QuotationImage;
use App\Models\QuotationMessage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QuotationController extends Controller
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

        $quotations = DB::table('quotations')
        ->where('deleted_at', '=', null)
        ->orderBy('created_at', 'DESC')->get();

        $products = DB::table('products')
        ->where('deleted_at', '=', null)
        ->orderBy('created_at', 'DESC')->get();

        $quotationMessages = DB::table('quotation_messages')
        ->join('users', 'quotation_messages.from_user_id', '=', 'users.id')
        ->select('quotation_messages.*', 'users.usertype as usertype', 'users.fname as fname', 'users.lname as lname')
        ->get();

        $users = DB::table('users')->where('deleted_at', '=', null)->get();
        $usertypes = DB::table('usertypes')->where('deleted_at', '=', null)->get();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'quotations' => $quotations,
            'quotationMessages' => $quotationMessages,
            'products' => $products,
            'users' => $users,
            'usertypes' => $usertypes,
        ])
        ->with('title', 'Quotations')
        ->with('main_content', 'dashboard.modules.quotations');
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
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $filenames = array();
        $quotationType = $request->input('quotation_type');

        // Bullet Proofing
        if($quotationType == 'bullet'){

            $validated = $request->validate([
                'plateNumber' => ['required'],
                'model' => ['required'],
                'other_model' => ['nullable'],
                'color' => ['required'],
                'services.*' => ['required'],
                'remarks' => ['nullable'],
                'filenames.*' => ['nullable']
            ]);

            // Handle file upload
            if ($request->hasFile('filenames')) {
                foreach($request->file('filenames') as $file){
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('quotations', $filename, 'public');
                    array_push($filenames, $filename);
                }  
            } else {
                $filename = "default.png"; 
            }

            $quotation = new Quotation();
            $quotation->user_id = $my_user->id;
            $quotation->reference = 'B-' . $this->generateQuotationID($this->getNextAutoIncrement('quotations'));
            $quotation->quotation_type = $quotationType;
            $quotation->plate_number = $validated['plateNumber'];
            $quotation->model = $validated['model'] == 'Other Model'?$validated['other_model']:$validated['model'];
            $quotation->unit_color = $validated['color'];
            $quotation->services = json_encode($validated['services']);
            $quotation->remarks = $validated['remarks'];
            $quotation->status = 'Pending';

            $quotation->save();

            // Notification
            $notif = new Notification();
            $notif->user_id = $my_user->id;
            $notif->message = "Your Bullet Proofing Quotation Request is submitted. You can see this in the Order Status > Quotations History for the Reply.";
            $notif->link = "/show-quotation/".$quotation->reference;
            $notif->isRead = false;
            $notif->save();

        // Glass Processing
        } elseif ($quotationType == 'glass') {

            $validated = $request->validate([
                'type.*' => ['required'],
                'thickness.*' => ['required'],
                'height1.*' => ['required'],
                'height2.*' => ['nullable'],
                'width1.*' => ['required'],
                'width2.*' => ['nullable'],
                'color.*' => ['required'],
                'quantity.*' => ['required'],
                'cutting_details.*' => ['nullable'],
                'filenames.*' => ['nullable']
            ]);

            // Handle file upload
            if ($request->hasFile('filenames')) {
                foreach($request->file('filenames') as $file){
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('quotations', $filename, 'public');
                    array_push($filenames, $filename);
                }  
            } else {
                $filename = "default.png"; 
            }

            $quotation = new Quotation();
            $quotation->user_id = $my_user->id;
            $quotation->reference = 'Q-' . $this->generateQuotationID($this->getNextAutoIncrement('quotations'));
            $quotation->quotation_type = $quotationType;
            $quotation->type = json_encode($validated['type']);
            $quotation->thickness = json_encode($validated['thickness']);
            $quotation->h1 = json_encode($validated['height1']);
            $quotation->h2 = json_encode($validated['height2']);
            $quotation->w1 = json_encode($validated['width1']);
            $quotation->w2 = json_encode($validated['width2']);
            $quotation->color = json_encode($validated['color']);
            $quotation->quantity = json_encode($validated['quantity']);
            $quotation->cutting_details = json_encode($validated['cutting_details']);
            
            $quotation->status = 'Pending';

            $quotation->save();

            // Notification
            $notif = new Notification();
            $notif->user_id = $my_user->id;
            $notif->message = "Your Glass Processing Quotation Request is submitted. You can see this in the Order Status > Quotations History for the Reply.";
            $notif->link = "/show-quotation/".$quotation->reference;
            $notif->isRead = false;
            $notif->save();

        }

        if(count($filenames) > 0){
            foreach($filenames as $image){
                $quotationImage = new QuotationImage();
                $quotationImage->quotation_id = $quotation->id;
                $quotationImage->filename = $image;
                $quotationImage->save();
            }
        }

        return redirect('/quotes-status')->with('success_msg', 'Quotation Request is submitted. Please wait for the Reply.');
 
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
        if ($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $quotations = DB::table('quotations')
        ->where('id', '=', $id)
        ->where('deleted_at', '=', null)->get();

        $quotationMessages = DB::table('quotation_messages')
        ->join('users', 'quotation_messages.from_user_id', '=', 'users.id')
        ->select('quotation_messages.*', 'users.usertype as usertype', 'users.fname as fname', 'users.lname as lname')
        ->where('quotation_messages.quotation_id', '=', $id)
        ->get();

        $quotationImages = DB::table('quotation_images')->where('quotation_id', '=', $id)->get();

        $users = DB::table('users')->where('usertype', '=', 3)->where('deleted_at', '=', null)->get();

        $products = DB::table('products')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->leftJoin('product_sub_categories', 'products.sub_category_id', '=', 'product_sub_categories.id')
            ->leftJoin(DB::raw('(SELECT product_id, MIN(filename) as filename FROM product_images GROUP BY product_id) as pi'), 'products.id', '=', 'pi.product_id')
            ->select(
                'products.*', 
                'product_categories.category as category',
                'product_sub_categories.category as sub_category',
                'pi.filename as image')
            ->where('products.deleted_at', '=', null)->get();

        return view('dashboard.modules.quotations-view', [
            'my_user' => $my_user,
            'quotation' => $quotations[0],
            'quotationMessages' => $quotationMessages,
            'quotationImages' => $quotationImages,
            'products' => $products,
            'users' => $users,
        ])
        ->with('title', 'Quotations');
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
        $quotation = Quotation::find($id);
        $quotation->delete();

        return redirect('/users')->with('success_msg', 'User Successfully Deleted');
    }

    /**
     * Show User a Get Quotation Form (Bullet Proofing)
     */
    public function quotationBulletProofing()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.quotation.bulletproof', [
            'my_user' => $my_user,
            'settings_nav' => $settings_nav,
        ]);
    }

    /**
     * Show User a Get Quotation Form (Glass Processing)
     */
    public function quotationGlassProcessing()
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
            ->where('products.deleted_at', '=', null)->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.quotation.glasspro', [
            'my_user' => $my_user,
            'products' => $products,
            'settings_nav' => $settings_nav,
        ]);
    }

    /**
     * Show User his/her Quotation Details
     */
    public function showQuotation($reference)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $quotation = DB::table('quotations')->where('reference', '=', $reference)->get();
        if($quotation == null || count($quotation) == 0) {
            return redirect('/profile')->with('error_msg', 'Invalid Quotation');
        }

        $quotationMessages = DB::table('quotation_messages')
        ->join('users', 'quotation_messages.from_user_id', '=', 'users.id')
        ->select('quotation_messages.*', 'users.usertype as usertype', 'users.fname as fname', 'users.lname as lname')
        ->where('quotation_messages.quotation_id', '=', $quotation[0]->id)
        ->get();

        $quotationImages = DB::table('quotation_images')->where('quotation_id', '=', $quotation[0]->id)->get();

        $products = DB::table('products')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->leftJoin('product_sub_categories', 'products.sub_category_id', '=', 'product_sub_categories.id')
            ->leftJoin(DB::raw('(SELECT product_id, MIN(filename) as filename FROM product_images GROUP BY product_id) as pi'), 'products.id', '=', 'pi.product_id')
            ->select(
                'products.*', 
                'product_categories.category as category',
                'product_sub_categories.category as sub_category',
                'pi.filename as image')
            ->where('products.deleted_at', '=', null)->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');
            
        return view('home.quotation.quote_msg', [
            'my_user' => $my_user,
            'quotation' => $quotation[0],
            'quotationMessages' => $quotationMessages,
            'quotationImages' => $quotationImages,
            'products' => $products,
            'settings_nav' => $settings_nav,
        ]);

    }

    /**
     * Show User his/her Quotation Messages
     */
    public function showQuotationMessages($reference)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $quotation = DB::table('quotations')->where('reference', '=', $reference)->get();
        if($quotation == null || count($quotation) == 0) {
            return redirect('/profile')->with('error_msg', 'Invalid Quotation');
        }

        $quotationMessages = DB::table('quotation_messages')
        ->join('users', 'quotation_messages.from_user_id', '=', 'users.id')
        ->select('quotation_messages.*', 'users.usertype as usertype', 'users.fname as fname', 'users.lname as lname')
        ->where('quotation_messages.quotation_id', '=', $quotation[0]->id)
        ->get();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.quotation.quote_messages', [
            'quotation' => $quotation[0],
            'quotationMessages' => $quotationMessages,
            'my_user' => $my_user,
        ]);

    }


    public function changeStatus(Request $request, $id)
    {

        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();


        $request->validate([
            'status' => 'required|string|max:255'
        ]);

        $quote = Quotation::find($id);
        $quote->status = $request->status;
        $quote->save();

        // Create Notif
        $notif = new Notification();
        $notif->user_id = $quote->user_id;
        $notif->message = "The Quotation status of ".$quote->reference." is changed to ".$quote->status;
        $notif->link = "/show-quotation/".$quote->reference;
        $notif->isRead = false;
        $notif->save();

        return redirect('/quotations')->with('success_msg', 'Status Changed');
    }


    /**
     * Update Status
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'quotation_id' => 'required|integer|exists:quotations,id',
            'status' => 'required|string|max:255'
        ]);

        $quotation = Quotation::find($request->quotation_id);
        $quotation->status = $request->status;
        $quotation->save();

        // Create Notif
        $notif = new Notification();
        $notif->user_id = $quotation->user_id;
        $notif->message = "The Quotation status of ".$quotation->reference." is changed to ".$quotation->status;
        $notif->link = "/show-quotation/".$quotation->reference;
        $notif->isRead = false;
        $notif->save();

        return response()->json(['message' => 'Status updated successfully.']);
    }

    /**
     * Update Status Sales Rep
     */
    public function updateStatusSales(Request $request, $id)
    {
        $request->validate([
            'quotation_id' => 'required|integer|exists:quotations,id',
            'status' => 'required|string|max:255'
        ]);

        $quotation = Quotation::find($request->quotation_id);
        if($request->status == 'Approved'){
            $quotation->isApprovedSales = true;
        } else {
            $quotation->isApprovedSales = false;
        }
        $quotation->isApprovedSales = true;
        $quotation->status = $request->status;
        $quotation->save();

        // Create Notif
        $notif = new Notification();
        $notif->user_id = $quotation->user_id;
        $notif->message = "The Quotation status of ".$quotation->reference." is changed to ".$quotation->status;
        $notif->link = "/show-quotation/".$quotation->reference;
        $notif->isRead = false;
        $notif->save();

        return redirect('/quotations')->with('quotation_id', $id)->with('success_msg', 'Approved');
    }

    /**
     * Cancel Quotation
     */
    public function cancel(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $id = $request->input('quotation_id');

        $quotation = Quotation::find($id);
        $quotation->status = 'Cancelled';
        $quotation->save();

        return redirect('/profile')->with('success_msg', $quotation->reference . ' Quotation Cancelled.');
    }

    /**
     * Approve Quotation
     */
    public function approve(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $id = $request->input('quotation_id');

        $quotation = Quotation::find($id);
        $quotation->isApprovedUser = true;
        $quotation->status = 'Approve';
        $quotation->save();

        return redirect('/profile')->with('success_msg', $quotation->reference . ' Quotation Approved.');
    }

    /**
     * Quotation to Cart
     */
    public function quotationToCart(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $id = $request->input('quotation_id');

        $quotation = Quotation::find($id);
        $quotation->status = 'Added to Cart';
        $quotation->save();

        $findQuotation = DB::table('carts')->where('quotation_id', '=', $id)->get();

        if(count($findQuotation) == 0){
            $cart = new Cart();
            $cart->user_id = $my_user->id;
            $cart->quotation_id = $id;
            $cart->quantity = 1;
            $cart->price = $quotation->final_price;
            $cart->save();
        }

        return redirect('/cart')->with('success_msg', $quotation->reference . ' Quotation Added to Cart.');
    }

    /**
     * Send Message as Admin
     */
    public function sendMessage(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $validated = $request->validate([
            'quotation_id' => ['required'],
            'message' => ['required'],
        ]);

        $quotationMessage = new QuotationMessage();
        $quotationMessage->quotation_id = $validated['quotation_id'];
        $quotationMessage->from_user_id = $my_user->id;
        $quotationMessage->message = $validated['message'];

        $quotationMessage->save();


        $quotations = DB::table('quotations')
        ->where('id', '=', $validated['quotation_id'])
        ->where('deleted_at', '=', null)
        ->orderBy('created_at', 'DESC')->get();

        $quotationMessages = DB::table('quotation_messages')
        ->join('users', 'quotation_messages.from_user_id', '=', 'users.id')
        ->select('quotation_messages.*', 'users.usertype as usertype', 'users.fname as fname', 'users.lname as lname')
        ->where('quotation_messages.quotation_id', '=', $validated['quotation_id'])
        ->get();

        $users = DB::table('users')->where('deleted_at', '=', null)->get();

        $products = DB::table('products')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->leftJoin('product_sub_categories', 'products.sub_category_id', '=', 'product_sub_categories.id')
            ->leftJoin(DB::raw('(SELECT product_id, MIN(filename) as filename FROM product_images GROUP BY product_id) as pi'), 'products.id', '=', 'pi.product_id')
            ->select(
                'products.*', 
                'product_categories.category as category',
                'product_sub_categories.category as sub_category',
                'pi.filename as image')
            ->where('products.deleted_at', '=', null)->get();

        $usertypes = DB::table('usertypes')->where('deleted_at', '=', null)->get();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'quotation' => $quotations[0],
            'quotationMessages' => $quotationMessages,
            'products' => $products,
            'users' => $users,
            'usertypes' => $usertypes,
        ])
        ->with('title', 'Quotations')
        ->with('main_content', 'dashboard.modules.quotations-view');

    }

    /**
     * Send Message as User
     */
    public function userSendMessage(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $validated = $request->validate([
            'quotation_id' => ['required'],
            'message' => ['required'],
        ]);
    
        $quotationMessage = new QuotationMessage();
        $quotationMessage->quotation_id = $validated['quotation_id'];
        $quotationMessage->from_user_id = $my_user->id;
        $quotationMessage->message = $validated['message'];

        $quotationMessage->save();


        $quotations = DB::table('quotations')
        ->where('id', '=', $validated['quotation_id'])
        ->where('deleted_at', '=', null)
        ->orderBy('created_at', 'DESC')->get();

        return redirect('/show-quotation/'.$quotations[0]->reference);

    }

    /**
     * Generates a GUID
     */
    public function generateGUID() 
    {
        if (function_exists('com_create_guid')) {
            return trim(com_create_guid(), '{}');
        }
    
        return sprintf(
            '%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0x0FFF) | 0x4000, // 4XXX - Version 4 UUID
            mt_rand(0, 0x3FFF) | 0x8000, // 8XXX, 9XXX, AXXX, or BXXX - Variant 1 UUID
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF)
        );
    }

    /**
     * Generates a Quotation ID
     */
    public function generateQuotationID($id)
    {
        $paddedId = str_pad($id, 6, '0', STR_PAD_LEFT); // Pad ID to 6 digits
        return "{$paddedId}-3"; // Append fixed suffix
    }

    /**
     * Gets Next Auto Increment
     */
    public function getNextAutoIncrement($table)
    {
        // Check if table exists
        if (!DB::getSchemaBuilder()->hasTable($table)) {
            return 0;
        }
    
        // Run the SHOW TABLE STATUS query
        $result = DB::select("SHOW TABLE STATUS LIKE '{$table}'");
    
        return $result[0]->Auto_increment ?? 0;
    }

    /**
     * Download Conforme User (To User / From Admin)
     */
    public function downloadConformeUser($id, $from = null)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if(!$my_user) return null;

        $quotation = Quotation::find($id);


        if(($quotation->filename_conforme == null || $quotation->filename_conforme == "") && $from == null){
            return redirect('/show-quotation/'.$quotation->reference)->with('error_msg', 'No Conforme Yet');
        } elseif(($quotation->filename_conforme == null || $quotation->filename_conforme == "") && $from != null){
            return redirect('/quotes-status')->with('error_msg', 'No Conforme Yet');
        }

        $filePath = 'conforme_sp/'.$quotation->filename_conforme; // path relative to storage/app

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found.');
        }
        
        return Storage::disk('public')
        ->download($filePath, $quotation->filename_conforme);
    }

    /**
     * Download Signed Conforme Sales Rep (To Sales Rep / From User)
     */
    public function downloadConformeSalesRep($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if(!$my_user) return null;

        $quotation = Quotation::find($id);

        if($quotation->filename_conforme_signed == null || $quotation->filename_conforme_signed == ""){
            return redirect('/quotations')->with('error_msg', 'No Conforme Yet');
        }

        $filePath = 'conforme_user/'.$quotation->filename_conforme_signed; // path relative to storage/app

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($filePath, $quotation->filename_conforme_signed);
    } 

    /**
     * Download AR User (To User / From Admin)
     */
    public function downloadARUser($id, $from = null)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if(!$my_user) return null;

        $quotation = Quotation::find($id);

        if(($quotation->filename_ar == null || $quotation->filename_ar == "") && $from == null){
            return redirect('/show-quotation/'.$quotation->reference)->with('error_msg', 'No Acknowledgement Receipt Yet');
        } elseif(($quotation->filename_ar == null || $quotation->filename_ar == "") && $from != null){
            return redirect('/quotes-status')->with('error_msg', 'No Acknowledgement Receipt Yet');
        }

        $filePath = 'ar_sp/'.$quotation->filename_ar; // path relative to storage/app

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($filePath, $quotation->filename_ar);
    }

    /**
     * Download Signed AR Sales Rep (To Sales Rep / From User)
     */
    public function downloadARSalesRep($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if(!$my_user) return null;

        $quotation = Quotation::find($id);

        if($quotation->filename_conforme_signed == null || $quotation->filename_conforme_signed == ""){
            return redirect('/quotations')->with('error_msg', 'No Acknowledgement Receipt Yet');
        }

        $filePath = 'ar_user/'.$quotation->filename_ar_signed; // path relative to storage/app

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($filePath, $quotation->filename_ar_signed);
    } 

    /**
     * Download Proof of Payment (Sales Rep)
     */
    public function downloadProofOfPayment($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if(!$my_user) return null;

        $quotation = Quotation::find($id);

        if($quotation->filename_proof_of_payment == null || $quotation->filename_proof_of_payment == ""){
            return redirect('/quotations/')->with('quotation_id', $quotation->id)->with('error_msg', 'No Proof of Payment Yet');
        }

        $filePath = 'proof/'.$quotation->filename_proof_of_payment; // path relative to storage/app

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($filePath, $quotation->filename_proof_of_payment);
    } 

    /**
     * Upload Conforme User Signed (From User)
     */
    public function uploadConformeUser(Request $request, $id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if(!$my_user) return null;

        $validated = $request->validate([
            'conforme' => ['nullable', 'file', 'max:4096'],
            'toStatus' => ['nullable'],
        ]);

        // Handle file upload
        if ($request->hasFile('conforme')) {
            $file = $request->file('conforme');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('conforme_user', $filename, 'public');
        }

        $quotation = Quotation::find($id);
        $quotation->filename_conforme_signed = $filename;
        $quotation->save();

        $filePath = 'conforme_user/'.$quotation->filename_conforme_signed; // path relative to storage/app

        $message = new QuotationMessage();
        $message->quotation_id = $quotation->id;
        $message->from_user_id = $my_user->id;
        $message->message = "<span style='color:red;'>Signed Conforme is uploaded by Customer.</span>";
        $message->save();

        if($validated['toStatus'] != null && $validated['toStatus'] == 'toStatus'){
            return redirect('/quotes-status')->with('success_msg', 'Conforme Uploaded');
        } else {
            return redirect('/show-quotation/'.$quotation->reference)->with('success_msg', 'Conforme Uploaded');
        }
    }

    /**
     * Upload Signed Conforme Sales Rep (To Sales Rep / From User)
     */
    public function uploadConformeSalesRep(Request $request, $id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if(!$my_user) return null;

        $validated = $request->validate([
            'conforme' => ['nullable', 'file', 'max:4096'],
        ]);

        // Handle file upload
        if ($request->hasFile('conforme')) {
            $file = $request->file('conforme');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('conforme_sp', $filename, 'public');
        }

        $quotation = Quotation::find($id);
        $quotation->filename_conforme = $filename;
        $quotation->save();

        $filePath = 'conforme_sp/'.$quotation->filename_conforme; // path relative to storage/app

        $message = new QuotationMessage();
        $message->quotation_id = $quotation->id;
        $message->from_user_id = $my_user->id;
        $message->message = "<span style='color:red;'>Quotation Document is uploaded by Sales Representative.</span>";
        $message->save();

        return redirect('/quotations')->with('quotation_id', $id)->with('success_msg', 'Conforme Uploaded');
    }

    /**
     * Upload AR User Signed (From User)
     */
    public function uploadARUser(Request $request, $id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if(!$my_user) return null;

        $validated = $request->validate([
            'ar' => ['nullable', 'file', 'max:4096'],
        ]);

        // Handle file upload
        if ($request->hasFile('ar')) {
            $file = $request->file('ar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('ar_user', $filename, 'public');
        }

        $quotation = Quotation::find($id);
        $quotation->filename_ar_signed = $filename;
        $quotation->save();

        $filePath = 'ar_user/'.$quotation->filename_ar_signed; // path relative to storage/app

        $message = new QuotationMessage();
        $message->quotation_id = $quotation->id;
        $message->from_user_id = $my_user->id;
        $message->message = "<span style='color:red;'>Signed Acknowledgement Receipt is uploaded by Customer.</span>";
        $message->save();

        return redirect('/show-quotation/'.$quotation->reference)->with('success_msg', 'Acknowledgement Receipt Uploaded');
    }

    /**
     * Upload Signed AR Sales Rep (To Sales Rep / From User)
     */
    public function uploadARSalesRep(Request $request, $id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if(!$my_user) return null;

        $validated = $request->validate([
            'ar' => ['nullable', 'file', 'max:4096'],
        ]);

        // Handle file upload
        if ($request->hasFile('ar')) {
            $file = $request->file('ar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('ar_sp', $filename, 'public');
        }

        $quotation = Quotation::find($id);
        $quotation->filename_ar = $filename;
        $quotation->save();

        $filePath = 'ar_sp/'.$quotation->filename_ar; // path relative to storage/app

        $message = new QuotationMessage();
        $message->quotation_id = $quotation->id;
        $message->from_user_id = $my_user->id;
        $message->message = "<span style='color:red;'>Acknowledgement Receipt is uploaded by Sales Rep.</span>";
        $message->save();

        return redirect('/quotations')->with('quotation_id', $id)->with('success_msg', 'AR Uploaded');
    }

    /**
     * Upload Proof of Payment (From User)
     */
    public function uploadProofOfPayment(Request $request, $id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if(!$my_user) return null;

        $validated = $request->validate([
            'proof' => ['nullable', 'file', 'max:4096'],
            'toStatus' => ['nullable'],
        ]);

        // Handle file upload
        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('proof', $filename, 'public');
        }

        $quotation = Quotation::find($id);
        $quotation->filename_proof_of_payment = $filename;
        $quotation->save();

        $filePath = 'proof/'.$quotation->filename_proof_of_payment; // path relative to storage/app

        $message = new QuotationMessage();
        $message->quotation_id = $quotation->id;
        $message->from_user_id = $my_user->id;
        $message->message = "<span style='color:red;'>Proof of Payment is uploaded by Customer.</span>";
        $message->save();

        if($validated['toStatus'] != null && $validated['toStatus'] == 'toStatus'){
            return redirect('/quotes-status')->with('success_msg', 'Proof of Payment Uploaded');
        } else {
            return redirect('/show-quotation/'.$quotation->reference)->with('success_msg', 'Proof of Payment Uploaded');
        }
    }

}
