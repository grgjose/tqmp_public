<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;
use App\Mail\RegistrationApprovalMail;
use App\Mail\RegistrationRejectionMail;
use App\Mail\UserCreationMail;
use App\Mail\ForgotPasswordMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use DateTime;


class UserController extends Controller
{
    /**
     * Default Display of Users Table
     */
    public function index()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        //$users = DB::table('users')->where('deleted_at', '=', null)->get();

        $users = DB::table('users')
        ->join('usertypes', 'users.usertype', '=', 'usertypes.id')
        ->select('users.*', 'usertypes.title as usertype_title')
        ->where('users.deleted_at', '=', null)
        ->get();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'users' => $users,
        ])
        ->with('title', 'Active Users')
        ->with('main_content', 'dashboard.settings.users');
    }

    /**
     * View Login
     */    
    public function login(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        return view("home.login", [
          'my_user' => $my_user  
        ]);
    }

    /**
     * View Register
     */   
    public function register()
    {

        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view("home.home.register", [
          'my_user' => $my_user,
          'settings_nav' => $settings_nav,
        ]);
    }

    /**
     * Sign-in Process
     */    
    public function logon(Request $request)
    {
        $validated = $request->validate([
            "email" => ['required', 'min:2'],
            "password" => ['required', 'min:2']
        ]);
        
        /** @var \App\Models\User|null $user */
        $user = \App\Models\User::where('email', $validated['email'])->first();

        if (!$user) {
            return redirect('/home')->with('error_msg', 'Invalid Credentials!');
        }
        
        // 🧠 Step 1: Check if the user has an active session
        if ($user->last_session_id) {
            $session = DB::table('sessions')->where('id', $user->last_session_id)->first();

            if ($session) {
                // Calculate if session is expired
                $lifetime = config('session.lifetime') * 60; // in seconds
                $lastActivity = $session->last_activity;

                if (time() - $lastActivity < $lifetime) {
                    // Session still active
                    return redirect('/home')->with('error_msg', 'This account is already logged in on another device/browser.');
                } else {
                    // Session expired, remove the stale session reference
                    $user->last_session_id = null;
                    $user->save();
                }
            } else {
                // Session ID no longer exists in DB
                $user->last_session_id = null;
                $user->save();
            }
        }

        // 🧠 Step 2: If Usertype == 3, Check Status and Email Verified At
        if ($user->usertype == 3) {
            if ($user->status === "registered") {
                return redirect('/home')->with('error_msg', 'Your user is not yet verified. Please wait for email confirmation.');
            }

            if ($user->email_verified_at == null) {
                return redirect('/home')->with('error_msg', 'Your email is not yet verified. Please check your email for the verification link.');
            }
        }

        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $remember = $request->input("remember_me");

        if($auth->attempt($validated, $remember) || $auth->viaRemember()){
            $request->session()->regenerate();

            // Save new session ID
            $user->last_session_id = Session::getId();
            $user->save();

            if ($user->usertype <= 2) {
                return redirect('/dashboard');
            } elseif ($user->status === "registered") {
                $auth->logout();
                return redirect('/home')->with('error_msg', 'Your user is not yet verified. Please wait for email confirmation.');
            } else {
                return redirect('/home');
            }

        } else {
            return redirect('/home')->with('error_msg', 'Invalid Credentials!');
        }
    }

    /**
     * Validate credentials only (pre-OTP check)
     */
    public function logon_check(Request $request)
    {
        $my_user = User::where('email', $request->input('email'))->first();

        if ($my_user == null) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.'
            ], 401);
        }

        if (!Hash::check($request->input('password'), $my_user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.'
            ], 401);
        }

        // Check account status before even sending OTP
        if ($my_user->usertype == 3) {
            if ($my_user->status === 'registered') {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is not yet verified.'
                ], 403);
            }

            if ($my_user->email_verified_at == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your email is not yet verified.'
                ], 403);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Credentials valid.'
        ], 200);
    }

    /**
     * Login of User (OTP Get)
     */
    public function logon_otp_get(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */


        $my_user = User::where('email', $request->input('email'))->first();

        if ($my_user == null) {
            return response()->json([
                'success' => false,
                'message' => 'User does not exist.'
            ], 401);
        }

        $otp = $this->generateOtp();
        //$otp = '123456'; //For Development Only

        $user = User::find($my_user->id);
        $msg = 'Please use this code to proceed with your verification. This code will expire in 5 minutes. Do not share it with anyone.';

        //If Number have +63, replace it with 0
        $number = $user->contact_num;
        if (substr($number, 0, 3) == "+63") {
            $number = "0" . substr($number, 3);
        }

        if ($user->otp == "" || $user->otp == null || $user->otp == "null" || $user->otp == 0) 
        {
            $user->otp = $otp;
            $user->otp_last_retry = now();
            $user->otp_retry = 1;
            $this->sendOtp($number, $msg, $otp);
        } 
        elseif ($user->otp_retry < 3) 
        {
            $user->otp = $otp;
            $user->otp_retry = $user->otp_retry + 1;
            $user->otp_last_retry = now();
            $this->sendOtp($number, $msg, $otp);
        }
        // If OTP retry is 3 but last retry was more than 5 minutes ago, allow to resend OTP
        elseif ($user->otp_last_retry < now()->subMinutes(5)) 
        {
            $user->otp = $otp;
            $user->otp_last_retry = now();
            $user->otp_retry = 1; // Reset retry count to 1 since we're allowing a new OTP to be sent
            $this->sendOtp($number, $msg, $otp);
        }
        // If OTP retry is 3 and last retry was less than 5 minutes ago, do not allow to resend OTP
        else 
        {
            return response()->json([
                'success' => false,
                'message' => 'OTP slots are full. Please try again later.'
            ], 400);
        }

        // Save to database
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'OTP generated successfully.'
        ], 200);
    }

    /**
     * Login of User (OTP Post) — creates session ONLY after OTP is verified
     */
    public function logon_otp_post(Request $request)
    {
        $my_user = User::where('email', $request->input('email'))->first();

        if ($my_user == null) {
            return response()->json([
                'success' => false,
                'message' => 'User does not exist.'
            ], 401);
        }

        $validated = $request->validate([
            'otp' => ['required']
        ]);

        $otp = $validated['otp'];
        $user = User::find($my_user->id);

        // OTP retry hard block
        if ($user->otp_retry >= 3 && $user->otp_last_retry > now()->subMinutes(5)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP slots are full. Try again after 5 minutes.',
            ], 400);
        }

        if ($otp != $user->otp) {
            $user->otp_retry = $user->otp_retry + 1;
            $user->save();

            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP. Try again.',
            ], 400);
        }

        // ✅ OTP is correct — NOW create the session
        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];

        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();

        if (!$auth->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication failed. Please try again.',
            ], 401);
        }

        if (is_null($user->email_verified_at) || strtolower(trim($user->status)) !== 'active') {

            $auth->logout(); // prevent login if conditions fail

            return response()->json([
                'success' => false,
                'message' => 'Email is not verified or account is inactive.',
            ], 403);
        }

        
        $request->session()->regenerate();

        // Clear OTP
        $user->otp = "";
        $user->otp_retry = 0;
        $user->otp_last_retry = null;

        // Save new session ID
        $user->last_session_id = Session::getId();
        $user->save();

        // Return redirect destination so frontend can follow it
        $redirect = $user->usertype <= 2 ? '/dashboard' : '/home';

        return response()->json([
            'success'  => true,
            'message'  => 'Login successful.',
            'redirect' => $redirect,
        ], 200);
    }

    /**
     * Logout a User
     */    
    public function logout(Request $request)
    {   
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $user  = $auth->user();

        if($user == null) { return redirect('/home'); }

        if ($user) {
            $user->last_session_id = null;
            $user->save();
        }
        
        $auth->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/home');
    }

    /**
     * Sign-up Process
     */    
    public function signup(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();
        
        $validated = $request->validate([
            'fname' => ['required', 'min:3'],
            'mname' => ['nullable'],
            'lname' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'birthdate' => ['required'],
            'contact_num' => ['required', 'regex:/^(09|\+639)\d{9}$/', 'unique:users,contact_num'],
            'password' => ['required'],
            'upload_file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        // Handle file upload
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $filename, 'public');
        } else {
            return response()->json(['error' => 'File upload failed'], 400);
        }

        $user = new User();

        $user->fname = $validated['fname'];
        $user->mname = $validated['mname'];
        $user->lname = $validated['lname'];
        $user->email = $validated['email'];
        $user->usertype = 3;
        $user->birthdate = $validated['birthdate'];
        $user->contact_num = $validated['contact_num'];
        $user->email_verification_token = $this->generateGUID();
        $user->email_verification_sent = date("Y-m-d H:i:s");
        $user->password = Hash::make($validated['password']);
        $user->upload_file = $filename;

        $user->save();

        $data = [
            'name' => $validated['fname'].' '.$validated['lname'],
            'message' => '',
            'email_token' => $user->email_verification_token
        ];
    
        Mail::to($validated['email'])->send(new RegistrationMail($data));

        return redirect('/home')->with('success_msg', 'PLEASE CHECK YOUR INBOX / SPAM EMAIL TO VERIFY YOUR ACCOUNT!');

    }

    /**
     * Email Confirmation Process
     */    
    public function confirmation($token)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();
        
        if($my_user != null) return redirect('/home')->with('error_msg', 'You are already signed in!');
        if($token == null) return redirect('/home')->with('error_msg', 'Invalid Token!');

        $users = DB::table('users')->where('email_verification_token', '=', $token)->get();

        if($users == null) return redirect('/home')->with('error_msg', 'Invalid Token!');
        if(count($users) == 0 || count($users) > 1) return redirect('/home')->with('error_msg', 'Invalid Token!');

        $user = User::find($users[0]->id);

        $datetime = new DateTime($user->email_verification_sent);
        $sevenDaysAgo = new DateTime("-7 days");
        
        if ($datetime < $sevenDaysAgo) return redirect('/home')->with('error_msg', 'Expired Token!');

        $user->email_verification_token = null;
        $user->email_verified_at = date("Y-m-d H:i:s");
        $user->email_verification_sent = null;

        $user->save();

        return redirect('/home')->with('success_msg', 'Email Verified, Please wait for the TQMP Sales Representative Email for the Validation of your Documents!');

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

        $usertypes = DB::table('usertypes')->get();

        return view('dashboard.settings.users-create', [
            'my_user' => $my_user,
            'usertypes' => $usertypes,
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
           'fname' => ['required', 'min:3'],
           'mname' => ['nullable'],
           'lname' => ['required'],
           'ext' => ['nullable'],
           'usertype' => ['required'],
           'email' => ['required'],
           'birthdate' => ['required'],
           'contact_num' => ['required'],
           'upload_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:4096'],
       ]);

       // Handle file upload
       if ($request->hasFile('upload_file')) {
           $file = $request->file('upload_file');
           $filename = time() . '_' . $file->getClientOriginalName();
           $file->storeAs('user-pics', $filename, 'public');
       } else {
           $filename = "default.png"; 
       }

       $password = $this->generatePassword();

       $user = new User();

       $user->fname = $validated['fname'];
       $user->mname = $validated['mname'];
       $user->lname = $validated['lname'];
       $user->email = $validated['email'];
       $user->usertype = $validated['usertype'];
       $user->birthdate = $validated['birthdate'];
       $user->contact_num = $validated['contact_num'];
       $user->email_verification_token = $this->generateGUID();
       $user->email_verification_sent = date("Y-m-d H:i:s");
       $user->status = "Active";
       $user->password = Hash::make($password);
       $user->upload_file = $filename;

       $user->save();

       $data = [
           'name' => $validated['fname'].' '.$validated['lname'],
           'message' => '',
           'password' => $password,
           'email_token' => $user->email_verification_token
       ];
   
       Mail::to($validated['email'])->send(new UserCreationMail($data));

       return redirect('/users')->with('success_msg', 'Please tell the User to check their Email!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $users = DB::table('users')->where('deleted_at', '=', null)->where('id', '=', $id)->get();

        if($users == null) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');
        if(count($users) == 0) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        return view('dashboard.settings.users-view', [
            'my_user' => $my_user,
            'user' => $users[0],
        ]);
    }

    /**
     * Display Active Customers Table (Consumers)
     */
    public function consumers()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $users = DB::table('users')
        ->where('usertype', '=', 3)->get();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'users' => $users,
        ])
        ->with('title', 'Consumers')
        ->with('main_content', 'dashboard.modules.consumers');
    }

    /**
     * Change the status of a consumer
     */
    public function changeConsumerStatus($id, $status)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $user = User::find($id);

        if (!$user) {
            return redirect('/dashboard')->with('error_msg', 'User not found!');
        }

        $user->status = $status;
        $user->save();

        return redirect('/consumers')->with('success_msg', 'Consumer status updated successfully!');
    }

    /**
     * Display pending approvals (Customer)
     */
    public function approvals()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $users = DB::table('users')
        ->where('usertype', '=', 3)
        ->where('status', 'registered')->get();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'users' => $users,
        ])
        ->with('title', 'Approvals')
        ->with('main_content', 'dashboard.modules.approvals');

    }

    /**
     * Display specific approval (Customer)
     */
    public function approvals_show($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $users = DB::table('users')
        ->where('usertype', '=', 3)
        ->where('status', 'registered')
        ->where('id', '=', $id)->get();

        if($users == null) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');
        if(count($users) == 0) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        return view('dashboard.modules.approvals-view', [
            'my_user' => $my_user,
            'user' => $users[0],
        ]);
    }

    /**
     * Download specific file (Customer)
     */
    public function approvals_download($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $users = DB::table('users')
        ->where('usertype', '=', 3)
        ->where('status', 'registered')
        ->where('id', '=', $id)->get();

        if($users == null) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');
        if(count($users) == 0) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        $path = storage_path("app/public/uploads/".$users[0]->upload_file);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->download($path);
    }

    /**
     * Approve a registered user (Customer)
     */
    public function approvals_approve(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $validated = $request->validate([
            'user_id' => ['required'],
        ]);

        $id = $validated['user_id'];

        $users = DB::table('users')
        ->where('usertype', '=', 3)
        ->where('status', 'registered')
        ->where('id', '=', $id)->get();

        if($users == null) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');
        if(count($users) == 0) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        $user = User::find($id);

        //Generate Customer Code (C-<6 digit number base on ID>-<3> where 3 is the usertype for customer)
        $customer_code = 'C-'.str_pad($user->id, 6, '0', STR_PAD_LEFT).'-3';

        $user->code = $customer_code;

        // Ensure email is verified before approving
        if($user->email_verified_at == null){
            return redirect('/approvals')->with('error_msg', 'User Email is not yet Verified!');
        }

        // Send Approval Email
        $data = [
            'name' => $user->fname.' '.$user->lname,
            'message' => 'Congratulations! Your account has been approved. You can now log in and start using our services.',
            'email_token' => $user->email_verification_token
        ];

        Mail::to($user->email)->send(new RegistrationApprovalMail($data));

        $user->status = "active";
        $user->save();

        return redirect('/approvals')->with('success_msg', $user->email.' is now an Active Customer!');
    }

    /**
     * Rejects a registered user (Customer)
     */
    public function approvals_reject($id, Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $users = DB::table('users')
        ->where('usertype', '=', 3)
        ->where('status', 'registered')
        ->where('id', '=', $id)->get();

        if($users == null) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');
        if(count($users) == 0) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        $user = User::find($id);
        $user->status = "rejected";
        $user->save();

        // Send Rejection Email
        $data = [
            'name' => $user->fname.' '.$user->lname,
            'message' => 'We regret to inform you that your account registration has been rejected. For more information, please contact our support team.',
            'email_token' => $user->email_verification_token
        ];
    
        Mail::to($user->email)->send(new RegistrationRejectionMail($data));

        return redirect('/approvals')->with('success_msg', $user->email.' is now a Rejected Customer!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 2) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $users = DB::table('users')->where('deleted_at', '=', null)->where('id', '=', $id)->get();

        if($users == null) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');
        if(count($users) == 0) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        return view('dashboard.settings.users-update', [
            'my_user' => $my_user,
            'user' => $users[0],
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

        
        $user = User::find($id);
        if($user == null) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        $validated = $request->validate([
            'fname' => ['required', 'min:3'],
            'mname' => ['nullable'],
            'lname' => ['required'],
            'email' => ['required'],
            'birthdate' => ['required'],
            'contact_num' => ['required'],
        ]);

        $user->fname = $validated['fname'];
        $user->mname = $validated['fname'];
        $user->lname = $validated['fname'];
        $user->email = $validated['fname'];
        $user->birthdate = $validated['fname'];
        $user->contact_num = $validated['fname'];

        $user->save();

        return $this->index();
    }

    /**
     * Update the specified resource in storage.
     */
    public function changepic($id, Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $users = DB::table('users')
        ->join('usertypes', 'users.usertype', '=', 'usertypes.id')
        ->select('users.*', 'usertypes.title as usertype_title')
        ->where('users.deleted_at', '=', null)
        ->get();

        if($users == null) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');
        if(count($users) == 0) return redirect('/dashboard')->with('error_msg', 'Unexpected Error!');

        // Handle file upload
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('user-pics', $filename, 'public');
        } else {
            return response()->json(['error' => 'File upload failed'], 400);
        }

        $user = User::find($id);
        $user->user_pic = $filename;
        $user->save();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'users' => $users,
        ])
        ->with('title', 'Active Users')
        ->with('main_content', 'dashboard.settings.users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/users')->with('success_msg', 'User Successfully Deleted');
    }

    /**
     * Sends Reset Password Link
     */
    public function forgot(Request $request)
    {

        $validated = $request->validate([
            'email' => ['required'],
        ]);

        $users = DB::table('users')->where('email', '=', $validated['email'])->get();

        if(count($users) == 0){
            return redirect('/home')->with('error_msg', 'No Users found with that Email!');
        }

        $token = $this->generateGUID();

        $user = User::find($users[0]->id);
        $user->forgot_password_token = $token;
        $user->forgot_password_sent = date("Y-m-d H:i:s");
        $user->save();

        $data = [
            'name' => $user->fname.' '.$user->lname,
            'message' => 'Please use the link below for the Password Reset Page',
            'token' => $token,
        ];

        Mail::to($validated['email'])->send(new ForgotPasswordMail($data));

        return redirect('/home')->with('success_msg', 'Please check your email!');
    }

    /**
     * Shows Reset Password Page
     */
    public function reset(string $reference)
    {

        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();
        
        // Find user directly with Eloquent (simpler and more readable)
        $user = User::where('forgot_password_token', $reference)->first();
    
        if (!$user) {
            return redirect('/home')->with('error_msg', 'Token expired or invalid');
        }
    
        // Check if token is older than 24 hours
        $tokenSentTime = Carbon::parse($user->forgot_password_sent);
        if ($tokenSentTime->addHours(24)->isPast()) {
            return redirect('/home')->with('error_msg', 'Token has expired. Please request a new one.');
        }

        $settings_nav = DB::table('settings')->where('key', 'like', 'NAVBAR_%')->pluck('value', 'key');

        return view('home.reset_password', [
            'user' => $user,
            'my_user' => $my_user,
            'settings_nav' => $settings_nav,
        ]);
    }

    /**
     * Perform Reset Password
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::find($validated['user_id']);

        if (!$user) {
            // Handle the case where the user doesn't exist
            return redirect('/home')->with('error_msg', 'User not found!');
        }

        $user->password = Hash::make($validated['password']);
        $user->save();
        
        return redirect('/home')->with('success_msg', 'Password Updated!');

    }

    /**
     * Confirm Old Password before changing it
     */    
    public function confirmPassword(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $validated = $request->validate([
            'password' => ['required'],
        ]);

        if (Hash::check($validated['password'], $my_user->password)) {
            return response()->json(['valid' => true]);
        } else {
            return response()->json(['error' => 'Invalid Old Password.'], 409);
        }
    }

    /**
     * Confirm Username before changing it
     */    
    public function confirmUsername(Request $request)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $validated = $request->validate([
            'username' => ['required'],
        ]);

        $users = DB::table('users')->where('username', '=', $validated['username'])->get(); 

        if (count($users) == 0) {
            return response()->json(['valid' => true]);
        } elseif (count($users) == 1 && $users[0]->id == $my_user->id) {
            // The username exists but belongs to the current user
            return response()->json(['valid' => true]);
        } else {
            // The username exists and belongs to another user
            return response()->json(['error' => 'Username already exists.'], 409);
        }
    }

    /**
     * Applies Discount to the User
     * 
     * @param int $id User ID
     * @return void
     */    
    public function applyDiscount($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $user = User::find($id);
        if($user == null) return redirect('/home')->with('error_msg', 'Unexpected Error!');

        // Check if the user is eligible for a discount
        if ($user->usertype == 3 && strtolower($user->status) == 'active') {
            // Apply discount logic here, e.g., update a discount field or send a notification
            $user->isDiscounted = true; // Example field, adjust as 
            $user->isSpecialDiscounted = false; // Example field, adjust as necessary
            $user->save(); 
            return redirect('/consumers')->with('success_msg', 'Discount applied to user successfully!');
        } else {
            return redirect('/consumers')->with('error_msg', 'User is not eligible for a discount.');
        }
    }

    /**
     * Applies Special Discount to the User
     * 
     * @param int $id User ID
     * @return void
     */    
    public function applySpecialDiscount($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $user = User::find($id);
        if($user == null) return redirect('/home')->with('error_msg', 'Unexpected Error!');

        // Check if the user is eligible for a discount
        if ($user->usertype == 3 && strtolower($user->status) == 'active') {
            // Apply discount logic here, e.g., update a discount field or send a notification
            $user->isDiscounted = false; // Example field, adjust as necessary
            $user->isSpecialDiscounted = true; // Example field, adjust as necessary
            $user->save(); 
            return redirect('/consumers')->with('success_msg', 'Special Discount applied to user successfully!');
        } else {
            return redirect('/consumers')->with('error_msg', 'User is not eligible for a discount.');
        }
    }

    /**
     * Remove Discount to the User
     * 
     * @param int $id User ID
     * @return void
     */    
    public function removeDiscount($id)
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $user = User::find($id);
        if($user == null) return redirect('/home')->with('error_msg', 'Unexpected Error!');

        // Check if the user is eligible for a discount
        if ($user->usertype == 3 && strtolower($user->status) == 'active') {
            // Apply discount logic here, e.g., update a discount field or send a notification
            $user->isDiscounted = false; // Example field, adjust as necessary
            $user->isSpecialDiscounted = false; // Example field, adjust as necessary
            $user->save(); 
            return redirect('/consumers')->with('success_msg', 'Discount removed to user successfully!');
        } else {
            return redirect('/consumers')->with('error_msg', 'User is not eligible for a discount removal.');
        }
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
     * Generates a Random Password
     */
    public function generatePassword($length = 8) 
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomPassword = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomPassword;
    }

    /**
     * Generate 6-digit OTP
     */
    public function generateOtp($length = 6)
    {
        return random_int(10 ** ($length - 1), (10 ** $length) - 1);
    }

    /**
     * Send 6-digit OTP
     */
    public function sendOtp($number, $message, $code)
    {
        // Implementation for sending OTP
        $response = Http::post('https://api.semaphore.co/api/v4/otp', [
            'apikey' => env('SEMAPHORE_API_KEY'),
            'number' => $number,
            'message' => $message,
            'sendername' => env('SEMAPHORE_SENDER_NAME'),
            'code' => $code,
        ]);

        if ($response->successful()) {
            return ['result' => true, 'status' => 'OTP sent successfully'];
        } else {
            return ['result' => false, 'status' => 'Failed to send OTP'];
        }
    }

    /**
     * Send SMS Message (Unused but can be used for future purposes like notifications)
     */
    public function sendMessage($number, $message)
    {
        $response = Http::post('https://api.semaphore.co/api/v4/messages', [
            'apikey' => env('SEMAPHORE_API_KEY'),
            'number' => $number,
            'message' => $message,
            'sendername' => env('SEMAPHORE_SENDER_NAME'),
        ]);

        if ($response->successful()) {
            return response()->json(['status' => 'Message sent successfully']);
        } else {
            return response()->json(['status' => 'Failed to send message'], 500);
        }
    }

}
