<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\Notification;
use App\Models\Shipping;
use App\Models\Lalamove;
use App\Models\User;
use Carbon\Carbon;

class OrderController extends Controller
{
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

        $orders = DB::table('orders')
            ->leftJoin('products', 'products.id', '=', 'orders.product_id')
            ->leftJoin('quotations', 'quotations.id', '=', 'orders.quotation_id')
            ->leftJoin('users as customers', 'customers.id', '=', 'orders.customer_id')
            ->leftJoin('users as sales_reps', 'sales_reps.id', '=', 'orders.sales_rep_id')
            ->leftJoin('lalamove', 'lalamove.order_id', '=', 'orders.id') // 👈 join lalamove table
            ->select(
                'orders.*',
                'products.name as product_name',
                'products.price as product_price',
                'products.display_name as product_display_name',
                DB::raw("CONCAT_WS(' ', customers.fname, customers.mname, customers.lname) as customer_fullname"),
                DB::raw("CONCAT_WS(' ', sales_reps.fname, sales_reps.mname, sales_reps.lname) as sales_rep_fullname"),
                'lalamove.order as lalamove_order' // 👈 get the "order" column from lalamove
            )
            ->get();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'orders' => $orders,
        ])
        ->with('title', 'Orders')
        ->with('main_content', 'dashboard.modules.orders');
    }

    // Lalamove API Functions

    public function lalamoveGetQuotation(Request $request)
    {

        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $order_id = $request->input('order_id');
        $quotation_id = $request->input('quotation_id');

        if($my_user == null){ 
            return response()->json([
                'status' => 404,
                'error' => 'No User Found'
            ], 404);
        }
        
        $data = [
            'serviceType' => $request->input('serviceType', 'SEDAN'), // Default to 'SEDAN' if not provided
            'latitude' => $request->input('latitude', '14.5995'), // Default to '14.5995' if not provided
            'longitude' => $request->input('longitude', '120.9842'), // Default to '120.9842' if not provided
            'address' => $request->input('address', 'Manila City Hall'), // Default to 'Manila City Hall' if not provided
            'specialRequests' => $request->input('specialRequests', ['DOCUMENT_HANDLING']), // Default to ['DOCUMENT_HANDLING'] if not provided
            'quantity' => $request->input('quantity', 1), // Default to 1 if not provided
            'weight' => $request->input('weight', 'MORE_THAN_10KG') // Default to 'MORE_THAN_10KG' if not provided
        ];
        
        return $this->lalamoveGetQuotationCore($data, $my_user);
        $jsonResponse = $this->lalamoveGetQuotationCore($data, $my_user);
        
        // Find User in Lalamove Table
        $lalamoveUser = DB::table('lalamove')->where('user_id', $my_user->id)->first();
        if($order_id != null){ $lalamoveUser = DB::table('lalamove')->where('user_id', $my_user->id)->where('order_id', $order_id)->first(); }
        if($quotation_id != null){ $lalamoveUser = DB::table('lalamove')->where('user_id', $my_user->id)->where('quotation_id', $quotation_id)->first(); }

        // If user does not exist, create a new one
        if (!$lalamoveUser) {

            $lalamove = new Lalamove();
            $lalamove->user_id = $my_user->id;
            if($order_id != null){ $lalamove->order_id = $order_id; }
            if($quotation_id != null){ $lalamove->quotation_id = $quotation_id; }
            $lalamove->quotation = $jsonResponse;
            $lalamove->save();

        } else {
            
            $lalamove = Lalamove::find($lalamoveUser->id);
            $lalamove->quotation = $jsonResponse;
            $lalamove->save();

        }

        return $jsonResponse;

    }

    public function lalamoveGetQuotationCore(array $data, $my_user)
    {
        if($my_user == null){
            return response()->json([
                'status' => 404,
                'error' => 'No User Found'
            ], 404);
        }

        $host = env('LALAMOVE_HOSTNAME');
        $path = '/v3/quotations';
        $method = 'POST';
        $apikey = env('LALAMOVE_API_KEY');  // pk_test_xxx
        $secret = env('LALAMOVE_SECRET_KEY'); // sk_test_xxx

        $timestamp = round(microtime(true) * 1000);

        // Validate Service Type
        $serviceType = $data['serviceType'];
        $validServiceTypes = [
            'MOTORCYCLE', 'SEDAN', 'SEDAN_INTERCITY', 'MPV', 'MPV_INTERCITY',
            'VAN', 'VAN_INTERCITY', 'TRUCK550', 'VAN1000', '2000KG_FB_LD',
            '2000KG_ALUMINUM_LD', '10WHEEL_TRUCK', 'LD_10WHEEL_TRUCK'
        ];

        if (!in_array($serviceType, $validServiceTypes)) {
            return response()->json([
                'status' => 400,
                'error' => 'Invalid Service Type'
            ], 400);
        }

        $serviceType = $data['serviceType'];
        $latitude    = $data['latitude'] ?? null;
        $longitude   = $data['longitude'] ?? null;
        $address     = $data['address'] ?? null;
        $specialRequests = $data['specialRequests'] ?? [];
        $quantity = $data['quantity'] ?? [];
        $weight = $data['weight'] ?? [];

        // Match the Postman body (use stringified version in signature!)
        $bodyArray = [
            "data" => [
                "scheduleAt" => Carbon::now()->addDays(1)->setTime(14, 30)->format('Y-m-d\TH:i:s.00\Z'),

                // Available Types: 
                // MOTORCYCLE, SEDAN, SEDAN_INTERCITY, MPV, MPV_INTERCITY, VAN, VAN_INTERCITY, 
                // TRUCK550, VAN1000, 2000KG_FB_LD, 2000KG_ALUMINUM_LD, 10WHEEL_TRUCK, LD_10WHEEL_TRUCK
                "serviceType" => strval($serviceType),

                // Available Special Requests:
                // LOADING_1HELPER_MAX2STOP, LOADING_1HELPER_MAX4STOP, LOADING_1HELPER_MIN5STOP, DOCUMENT_HANDLING
                "specialRequests" => $specialRequests,
                "language" => "en_PH",
                "stops" => [
                    [
                        "coordinates" => [
                            "lat" => "14.723465216697246",
                            "lng" => "120.98616319647962"
                        ],
                        "address" => "168 Sapang Bakaw, Valenzuela, Metro Manila"
                    ],
                    [
                        "coordinates" => [
                            "lat" => strval($latitude),
                            "lng" => strval($longitude)
                        ],
                        "address" => strval($address)
                    ],
                ],
                "isRouteOptimized" => true,
                "item" => [
                    "quantity" => strval($quantity ?? 1), // Default to 1 if not provided
                    "weight" => strval($weight), // Use the provided weight or default to 'MORE_THAN_10KG'
                    "handlingInstructions" => ["KEEP_UPRIGHT"]
                ]
            ]
        ];

        // JSON encode with no extra slashes
        $bodyJson = json_encode($bodyArray, JSON_UNESCAPED_SLASHES);

        // Step 1: Create string to sign (must match Postman's)
        $stringToSign = "{$timestamp}\r\n{$method}\r\n{$path}\r\n\r\n{$bodyJson}";

        // Step 2: Generate signature
        $signature = hash_hmac('sha256', $stringToSign, $secret);

        // Step 3: Construct Authorization header
        $authorization = "hmac {$apikey}:{$timestamp}:{$signature}";

        // Step 4: Send the HTTP request
        $response = Http::withHeaders([
            'Authorization' => $authorization,
            'Content-Type' => 'application/json',
            'Market' => 'PH'
        ])->post("https://{$host}{$path}", $bodyArray);

        // Check if the response is successful
        if ($response->successful()) {

            return $response->json();
        }

        return response()->json([
            'status' => $response->status(),
            'error' => $response->body()
        ], $response->status());
        
    }

    public function lalamoveGetQuotationDetails(Request $request)
    {

        $host = env('LALAMOVE_HOSTNAME');
        $path = '/v3/quotations';
        $method = 'POST';
        $apikey = env('LALAMOVE_API_KEY');  // pk_test_xxx
        $secret = env('LALAMOVE_SECRET_KEY'); // sk_test_xxx

        $timestamp = round(microtime(true) * 1000);

        // Match the Postman body (use stringified version in signature!)
        $bodyArray = [
            "data" => [
                "scheduleAt" => Carbon::now()->addDays(4)->setTime(14, 30)->format('Y-m-d\TH:i:s.00\Z'),
                "serviceType" => "LD_10WHEEL_TRUCK",
                "specialRequests" => ["HELPER_2"],
                "language" => "en_PH",
                "stops" => [
                    [
                        "coordinates" => [
                            "lat" => strval($request->input('latitude')),
                            "lng" => strval($request->input('longitude'))
                            // "lat" => "14.723465216697246",
                            // "lng" => "120.98616319647962"
                        ],
                        "address" => strval($request->input('address'))
                        // "address" => "168 Sapang Bakaw, Valenzuela, Metro Manila"
                    ],
                    [
                        "coordinates" => [
                            "lat" => "14.723465216697246",
                            "lng" => "120.98616319647962"
                        ],
                        "address" => "168 Sapang Bakaw, Valenzuela, Metro Manila"
                    ]
                ],
                "isRouteOptimized" => true,
                "item" => [
                    "quantity" => "2",
                    "weight" => "MORE_THAN_10KG",
                    "handlingInstructions" => ["KEEP_UPRIGHT"]
                ]
            ]
        ];

        // JSON encode with no extra slashes
        $bodyJson = json_encode($bodyArray, JSON_UNESCAPED_SLASHES);

        // Step 1: Create string to sign (must match Postman's)
        $stringToSign = "{$timestamp}\r\n{$method}\r\n{$path}\r\n\r\n{$bodyJson}";

        // Step 2: Generate signature
        $signature = hash_hmac('sha256', $stringToSign, $secret);

        // Step 3: Construct Authorization header
        $authorization = "hmac {$apikey}:{$timestamp}:{$signature}";

        // Step 4: Send the HTTP request
        $response = Http::withHeaders([
            'Authorization' => $authorization,
            'Content-Type' => 'application/json',
            'Market' => 'PH'
        ])->post("https://{$host}{$path}", $bodyArray);

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'status' => $response->status(),
            'error' => $response->body()
        ], $response->status());
    }

    public function lalamovePlaceOrder(Request $request)
    {

        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null){ return "No User"; }

        $host = env('LALAMOVE_HOSTNAME');
        $path = '/v3/orders';
        $method = 'POST';
        $apikey = env('LALAMOVE_API_KEY');  // pk_test_xxx
        $secret = env('LALAMOVE_SECRET_KEY'); // sk_test_xxx

        $timestamp = round(microtime(true) * 1000);

        $lalamove = Lalamove::where('user_id', $my_user->id)->first();

        if (!$lalamove) {
            return response()->json([
                'status' => 404,
                'error' => 'Lalamove user not found'
            ], 404);
        }

        $quotationId = $lalamove->quotation['data']['quotationId'] ?? null;
        $stopId0 = $lalamove->quotation['data']['stops'][0]['stopId'] ?? null;
        $stopId1 = $lalamove->quotation['data']['stops'][1]['stopId'] ?? null;
        
        if (!$quotationId) {
            return response()->json([
                'status' => 404,
                'error' => 'Lalamove user not found'
            ], 404);
        }

        // Match the Postman body (use stringified version in signature!)
        $bodyArray = [
            "data" => [
                "quotationId" => strval($quotationId),
                "sender" => [
                    "stopId" => strval($stopId0),
                    //"name" => strval($request->input('fullname')),
                    //"phone" => strval($request->input('contact_num'))
                    "name" => "John Doe",
                    "phone" => "+639123456789"
                ],
                "recipients" => [
                    [
                        "stopId" => strval($stopId1),
                        //"name" => strval($request->input('fullname')),
                        //"phone" => strval($request->input('contact_num'))
                        "name" => "Edwin Barillo",
                        "phone" => "+639262719107",
                        "remarks" => "Take photo of Recipient"
                    ]
                ],
                "isPODEnabled" => true,
                "partner" => "Lalamove Partner 1"
            ]
        ];

        // JSON encode with no extra slashes
        $bodyJson = json_encode($bodyArray, JSON_UNESCAPED_SLASHES);

        // Step 1: Create string to sign (must match Postman's)
        $stringToSign = "{$timestamp}\r\n{$method}\r\n{$path}\r\n\r\n{$bodyJson}";

        // Step 2: Generate signature
        $signature = hash_hmac('sha256', $stringToSign, $secret);

        // Step 3: Construct Authorization header
        $authorization = "hmac {$apikey}:{$timestamp}:{$signature}";

        // Step 4: Send the HTTP request
        $response = Http::withHeaders([
            'Authorization' => $authorization,
            'Content-Type' => 'application/json',
            'Market' => 'PH'
        ])->post("https://{$host}{$path}", $bodyArray);

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'status' => $response->status(),
            'error' => $response->body()
        ], $response->status());
    }

    public function lalamovePlaceOrderCore(array $data, $my_user)
    {

        if($my_user == null){ 
            return response()->json([
                'status' => 404,
                'error' => 'No User Found'
            ], 404);
        }

        $host = env('LALAMOVE_HOSTNAME');
        $path = '/v3/orders';
        $method = 'POST';
        $apikey = env('LALAMOVE_API_KEY');  // pk_test_xxx
        $secret = env('LALAMOVE_SECRET_KEY'); // sk_test_xxx

        $timestamp = round(microtime(true) * 1000);

        $lalamove = Lalamove::where('order_id', $data['order_id'])->first();

        if (!$lalamove) {
            return response()->json([
                'status' => 404,
                'error' => 'Lalamove user not found'
            ], 404);
        }

        $quotationId = $lalamove->quotation['data']['quotationId'] ?? null;
        $stopId0 = $lalamove->quotation['data']['stops'][0]['stopId'] ?? null;
        $stopId1 = $lalamove->quotation['data']['stops'][1]['stopId'] ?? null;
        
        if (!$quotationId) {
            return response()->json([
                'status' => 404,
                'error' => 'Lalamove user not found'
            ], 404);
        }

        // Match the Postman body (use stringified version in signature!)
        $bodyArray = [
            "data" => [
                "quotationId" => strval($quotationId),
                "sender" => [
                    "stopId" => strval($stopId0),
                    //"name" => strval($request->input('fullname')),
                    //"phone" => strval($request->input('contact_num'))
                    "name" => "John Doe",
                    "phone" => "+639123456789"
                ],
                "recipients" => [
                    [
                        "stopId" => strval($stopId1),
                        //"name" => strval($request->input('fullname')),
                        //"phone" => strval($request->input('contact_num'))
                        "name" => "Edwin Barillo",
                        "phone" => "+639262719107",
                        "remarks" => "Take photo of Recipient"
                    ]
                ],
                "isPODEnabled" => true,
                "partner" => "Lalamove Partner 1"
            ]
        ];

        // JSON encode with no extra slashes
        $bodyJson = json_encode($bodyArray, JSON_UNESCAPED_SLASHES);

        // Step 1: Create string to sign (must match Postman's)
        $stringToSign = "{$timestamp}\r\n{$method}\r\n{$path}\r\n\r\n{$bodyJson}";

        // Step 2: Generate signature
        $signature = hash_hmac('sha256', $stringToSign, $secret);

        // Step 3: Construct Authorization header
        $authorization = "hmac {$apikey}:{$timestamp}:{$signature}";

        // Step 4: Send the HTTP request
        $response = Http::withHeaders([
            'Authorization' => $authorization,
            'Content-Type' => 'application/json',
            'Market' => 'PH'
        ])->post("https://{$host}{$path}", $bodyArray);

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'status' => $response->status(),
            'error' => $response->body()
        ], $response->status());
    }

    public function lalamoveGetOrderDetailsCore(string $orderId)
    {
        $host   = env('LALAMOVE_HOSTNAME');
        $path   = "/v3/orders/{$orderId}";
        $method = 'GET';
        $apikey = env('LALAMOVE_API_KEY');   // pk_test_xxx
        $secret = env('LALAMOVE_SECRET_KEY'); // sk_test_xxx

        $timestamp = round(microtime(true) * 1000);

        // Step 1: Create string to sign (GET has no body, so end with \r\n\r\n only)
        $stringToSign = "{$timestamp}\r\n{$method}\r\n{$path}\r\n\r\n";

        // Step 2: Generate signature
        $signature = hash_hmac('sha256', $stringToSign, $secret);

        // Step 3: Construct Authorization header
        $authorization = "hmac {$apikey}:{$timestamp}:{$signature}";

        // Step 4: Send the HTTP request
        $response = Http::withHeaders([
            'Authorization' => $authorization,
            'Content-Type'  => 'application/json',
            'Market'        => 'PH'
        ])->get("https://{$host}{$path}");

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'status' => $response->status(),
            'error'  => $response->body()
        ], $response->status());
    }

    public function lalamoveGetDriverDetailsCore(string $orderId, string $driverId)
    {
        $host   = env('LALAMOVE_HOSTNAME');
        $path   = "/v3/orders/{$orderId}/drivers/{$driverId}";
        $method = 'GET';
        $apikey = env('LALAMOVE_API_KEY');   // pk_test_xxx
        $secret = env('LALAMOVE_SECRET_KEY'); // sk_test_xxx

        $timestamp = round(microtime(true) * 1000);

        // Step 1: Create string to sign (GET has no body, so end with \r\n\r\n only)
        $stringToSign = "{$timestamp}\r\n{$method}\r\n{$path}\r\n\r\n";

        // Step 2: Generate signature
        $signature = hash_hmac('sha256', $stringToSign, $secret);

        // Step 3: Construct Authorization header
        $authorization = "hmac {$apikey}:{$timestamp}:{$signature}";

        // Step 4: Send the HTTP request
        $response = Http::withHeaders([
            'Authorization' => $authorization,
            'Content-Type'  => 'application/json',
            'Market'        => 'PH'
        ])->get("https://{$host}{$path}");

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'status' => $response->status(),
            'error'  => $response->body()
        ], $response->status());
    }

    public function lalamoveCancelOrder(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) {
            return "No User";
        }

        $lalamove = Lalamove::where('user_id', $my_user->id)->first();

        if (!$lalamove) {
            return response()->json([
                'status' => 404,
                'error' => 'Lalamove user not found'
            ], 404);
        }

        $orderId = $lalamove->order['data']['orderId'] ?? null;

        if (!$orderId) {
            return response()->json([
                'status' => 404,
                'error' => 'Lalamove orderId not found'
            ], 404);
        }

        $host = env('LALAMOVE_HOSTNAME');
        $path = '/v3/orders/' . $orderId;
        $method = 'DELETE';
        $apikey = env('LALAMOVE_API_KEY');
        $secret = env('LALAMOVE_SECRET_KEY');

        $timestamp = round(microtime(true) * 1000);

        // Body is {} exactly like Postman
        $bodyJson = json_encode(new \stdClass(), JSON_UNESCAPED_SLASHES);

        // Signature string
        $stringToSign = "{$timestamp}\r\n{$method}\r\n{$path}\r\n\r\n{$bodyJson}";

        // Signature
        $signature = hash_hmac('sha256', $stringToSign, $secret);

        // Auth header
        $authorization = "hmac {$apikey}:{$timestamp}:{$signature}";

        // Send DELETE request with body
        $response = Http::withHeaders([
            'Authorization' => $authorization,
            'Content-Type' => 'application/json',
            'Market' => 'PH'
        ])->withBody($bodyJson, 'application/json')
        ->send($method, "https://{$host}{$path}");

        if ($response->successful()) {
            return $response->json() . $response->status();
        }

        return response()->json([
            'status' => $response->status(),
            'error' => $response->body()
        ], $response->status());
    }

    public function getQuotation($orderId, $serviceType = "SEDAN", $quantity = 1)
    {

        $order = Order::find($orderId);

        if (!$order) {
            return response()->json([
                'status' => 404,
                'error' => 'Order not found'
            ], 404);
        }

        $user = User::find($order->customer_id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'error' => 'User not found'
            ], 404);
        }

        $shippings = Shipping::where('user_id', $user->id)->where('isDefault', true)->first();
        $shipping = Shipping::find($shippings->id);

        

        if($serviceType == "10WHEEL_TRUCK"){
            $specialRequests = ['LOADING_1HELPER_MAX2STOP'];
        } 
        elseif($serviceType == "MOTORCYCLE") {
            $specialRequests = [];
        }
        else {
            $specialRequests = ['LOADING_SERVICE'];
        }

        $data = [
            'serviceType' => $serviceType,
            'latitude' => $shipping->lat,
            'longitude' => $shipping->lng,
            'address' => $shipping->address,
            'specialRequests' => $specialRequests,
            'quantity' => $quantity,
            'weight' => 'MORE_THAN_10KG'
        ];

        $jsonResponse = $this->lalamoveGetQuotationCore($data, $user);

        // Find User in Lalamove Table
        $lalamoveUser = DB::table('lalamove')->where('user_id', $user->id)->where('order_id', $orderId)->first();

        // If user does not exist, create a new one
        if (!$lalamoveUser) {

            $lalamove = new Lalamove();
            $lalamove->user_id = $user->id;
            $lalamove->order_id = $orderId;
            $lalamove->quotation = $jsonResponse;
            $lalamove->save();

        } else {
            
            $lalamove = Lalamove::find($lalamoveUser->id);
            $lalamove->quotation = $jsonResponse;
            $lalamove->save();
            
        }

        return $jsonResponse;

    }

    /**
     * Download Acknowledgement Receipt for an Order (user-facing)
     */
    public function downloadAR($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $order = \App\Models\Order::where('id', $id)
                                ->where('customer_id', $my_user->id)
                                ->firstOrFail();

        if (!$order->proof_of_payment) {
            return redirect()->back()->with('error_msg', 'No Acknowledgement Receipt available yet.');
        }

        $filePath = storage_path('app/public/proof/' . $order->proof_of_payment);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error_msg', 'File not found.');
        }

        return response()->download($filePath, 'acknowledgement_receipt_' . $order->reference_num . '.pdf');
    }

    public function placeOrder(Request $request)
    {

        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null){ return "No User Found"; }

        $validated = $request->validate([
            'order_id' => ['required'],
        ]);

        $order = Order::find($validated['order_id']);

        if($order == null){ return "Invalid Order"; }

        $data = [
            'order_id' => $order->id,
        ];

        $jsonResponse = $this->lalamovePlaceOrderCore($data, $my_user);

        // Find User in Lalamove Table
        $lalamoveUser = DB::table('lalamove')->where('user_id', $order->customer_id)->where('order_id', $order->id)->first();

        // If user does not exist, create a new one
        if (!$lalamoveUser) {

            $lalamove = new Lalamove();
            $lalamove->user_id = $order->customer_id;
            $lalamove->order = $jsonResponse;
            $lalamove->save();

        } else {
            
            $lalamove = Lalamove::find($lalamoveUser->id);
            $lalamove->order = $jsonResponse;
            $lalamove->save();

        }

        return redirect('/order')->with('success_msg', 'Order Placed');
    }

    public function getOrderDetails($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json([
                'status' => 404,
                'error' => 'Order not found'
            ], 404);
        }

        $user = User::find($order->customer_id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'error' => 'User not found'
            ], 404);
        }

        // Find User in Lalamove Table
        $lalamoveUser = DB::table('lalamove')->where('user_id', $user->id)->where('order_id', $orderId)->first();

        if($lalamoveUser != null){
            $lalamove = Lalamove::find($lalamoveUser->id);
            
            if($lalamove->order == null){
                return response()->json([
                    'status' => 404,
                    'error' => 'Placed Order not found'
                ], 404);
            }
        }

        // Get orderId from the $lalamove->order
        $lalamoveOrderId = $lalamove->order['data']['orderId'];

        return $this->lalamoveGetOrderDetailsCore($lalamoveOrderId);

    }

    public function getDriverDetails($orderId, $driverId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json([
                'status' => 404,
                'error' => 'Order not found'
            ], 404);
        }

        $user = User::find($order->customer_id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'error' => 'User not found'
            ], 404);
        }

        // Find User in Lalamove Table
        $lalamoveUser = DB::table('lalamove')->where('user_id', $user->id)->where('order_id', $orderId)->first();

        if($lalamoveUser != null){
            $lalamove = Lalamove::find($lalamoveUser->id);
            
            if($lalamove->order == null){
                return response()->json([
                    'status' => 404,
                    'error' => 'Placed Order not found'
                ], 404);
            }
        }

        // Get orderId from the $lalamove->order
        $lalamoveOrderId = $lalamove->order['data']['orderId'];

        return $this->lalamoveGetDriverDetailsCore($lalamoveOrderId, $driverId);
    }

    public function cancelOrder($orderId)
    {
        //
    }

    /**
     * Change the status of an entire order (order-level).
     * This is the existing method, updated to reference $order->reference_num
     * correctly now that price/quantity no longer live on the order row.
     */
    public function changeStatus(Request $request, $id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();
 
        $request->validate([
            'status' => 'required|string|max:255',
        ]);
 
        $order = \App\Models\Order::find($id);
 
        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }
 
        $order->status       = $request->status;
        $order->sales_rep_id = $my_user->id;
        $order->save();
 
        // Create in-app notification for the customer
        $notif          = new \App\Models\Notification();
        $notif->user_id = $order->customer_id;
        $notif->message = 'The status of Order ' . $order->reference_num . ' has been updated to: ' . $request->status;
        $notif->link    = '/order-status/' . $order->reference_num;
        $notif->isRead  = false;
        $notif->save();
 
        return response()->json([
            'success' => true,
            'message' => 'Order status updated.',
            'status'  => $order->status,
        ]);
    }

    /**
     * Change the status of a single order item (item-level).
     * Route suggestion: POST /order-item/{id}/status
     */
    public function changeItemStatus(Request $request, $id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();
 
        $request->validate([
            'status' => 'required|string|max:255',
        ]);
 
        $item = \App\Models\OrderItem::find($id);
 
        if (!$item) {
            return response()->json(['error' => 'Order item not found.'], 404);
        }
 
        $item->status = $request->status;
        $item->save();
 
        // Optionally notify the customer about the item status change
        $order = $item->order;
        if ($order) {
            $notif          = new \App\Models\Notification();
            $notif->user_id = $order->customer_id;
            $notif->message = 'An item in your order ' . $order->reference_num . ' has been updated to: ' . $request->status;
            $notif->link    = '/order-status/' . $order->reference_num;
            $notif->isRead  = false;
            $notif->save();
        }
 
        return response()->json([
            'success' => true,
            'message' => 'Item status updated.',
            'status'  => $item->status,
        ]);
    }

    public function setShipping()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();
        $apiKey = env('GOOGLE_API_KEY');
        $hostname = env('APP_URL');

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.userPage.shipping', [
            'my_user' => $my_user,
            'apiKey' => $apiKey,
            'hostname' => $hostname,
            'settings_nav' => $settings_nav
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

        return redirect('/cart')->with('success_msg', 'Shipping Address Saved');

    }

    public function assignShipping(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $validated = $request->validate([
            'fullname' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'contact' => ['required', 'string'],
            'lat' => ['required', 'numeric'],
            'long' => ['required', 'numeric'],
            'delivery_fee' => ['required', 'numeric'],
            'instructions' => ['nullable', 'string'],
        ]);

        $shipping = new Shipping();
        $shipping->user_id = $my_user->id;
        $shipping->lat = $validated['lat'];
        $shipping->long = $validated['long'];
        $shipping->full_name = $validated['fullname'];
        $shipping->email = $validated['email'];
        $shipping->contact = $validated['contact'];
        $shipping->instructions = $validated['instructions'];
        $shipping->delivery_fee = $validated['delivery_fee'];
        $shipping->save();
        
        // Create Notif 
        $notif = new Notification();
        $notif->user_id = $my_user->id;
        $notif->message = "New Shipping information has been saved successfully.";
        $notif->link = "/profile";
        $notif->isRead = false;
        $notif->save();

        return redirect('/cart')->with('success_msg', 'Shipping Information Saved');

    }

    public function ticketing()
    {

        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view("dashboard.ticketing", [
            'my_user' => $my_user
        ]);
    }
}
