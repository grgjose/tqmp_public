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
use App\Models\Setting;
use App\Models\User;
use App\Models\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
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

        $settings = DB::table('settings')->get();

        return view('dashboard.index', [
            'settings' => $settings,
            'my_user' => $my_user,
        ])
            ->with('title', 'Admin Control')
            ->with('main_content', 'dashboard.settings.admin-control');
    }

    /**
     * Load Tab in Admin Control Table
     */
    public function loadTab($name = "")
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();

        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if ($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $settings = DB::table('settings')->get();

        switch ($name) {
            case 'home':
                return view('plus.settings_home', ['settings' => $settings]);
            case 'bullet':
                return view('plus.settings_bullet', ['settings' => $settings]);
            case 'glass_mfg':
                return view('plus.settings_glass_mfg', ['settings' => $settings]);
            case 'aluminum_mfg':
                return view('plus.settings_aluminum_mfg', ['settings' => $settings]);
            case 'glass_pro':
                return view('plus.settings_glass_pro', ['settings' => $settings]);
            case 'about':
                return view('plus.settings_about', ['settings' => $settings]);
            case 'contact':
                return view('plus.settings_contact', ['settings' => $settings]);
            case 'navbar':
                return view('plus.settings_navbar', ['settings' => $settings]);
            case 'welcome':
                return view('plus.settings_welcome', ['settings' => $settings]);
            case 'all':
                return view('plus.settings_all', ['settings' => $settings]);
            default:
                return '<div class="p-3 text-danger">Tab not found.</div>';
        }
    }

    /**
     * Store a new resource in storage.
     */
    public function store(Request $request)
    {
        $my_user = auth()->user();
        if ($my_user == null) {
            return redirect('/home')->with('error_msg', 'Login First');
        }
        if ($my_user->usertype > 1) {
            return redirect('/home')->with('error_msg', 'Invalid Access!');
        }

        // Validate the request
        $validated = $request->validate([
            'profile_title' => ['nullable', 'string', 'max:255'],
            'profile_image' => ['nullable', 'file', 'max:5120'], // Max 5MB
            'timeline_year' => ['nullable'],
            'timeline_desc' => ['nullable'],
            'timeline_image' => ['nullable', 'file', 'max:5120'],
            'video_link' => ['nullable', 'string', 'max:255'],
        ]); 

        if(isset($validated['profile_image'])){
            $settings = DB::table('settings')->where('key', 'like', 'ALUMINUM_MFG_PROFILE_%')->get();
            $count = ($settings->count() / 2) + 1;

            // Handle file upload

            $file = $request->file('profile_image');
            if($file != null){
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('aluminum', $filename, 'public');
            }

            // Create new setting entry
            $setting1 = new Setting();
            $setting1->key = 'ALUMINUM_MFG_PROFILE_TITLE' . $count;
            $setting1->type = 'Text';
            $setting1->description = 'Aluminum Profile Title';
            $setting1->value = $validated['profile_title'];
            $setting1->save();

            $setting2 = new Setting();
            $setting2->key = 'ALUMINUM_MFG_PROFILE_IMAGE' . $count;
            $setting2->type = 'Image';
            $setting2->description = 'Aluminum Profile Image';
            $setting2->value = $filename;
            $setting2->save();


            // Log the action
            $log = new Log();
            $log->user_id = $my_user->id ?? null;
            $log->action = 'Added new aluminum profile setting with id ' . $setting1->id;
            $log->details = 'Added aluminum profile ' . $request->input('profile_title') . ' with file ' . $filename . ' ID: ' . $setting1->id;
            $log->save();

            $activeTab = '#tab-3';
        }

        if(isset($validated['timeline_image'])){

            $settings = DB::table('settings')->where('key', 'like', 'ABOUT_US_TIMELINE_%')->get();
            $count = ($settings->count() / 3) + 1;

            // Handle file upload

            $file = $request->file('timeline_image');
            if($file != null){
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('about-us', $filename, 'public');
            }

            // Create new setting entry
            $setting3 = new Setting();
            $setting3->key = 'ABOUT_US_TIMELINE_YEAR' . $count;
            $setting3->type = 'Text';
            $setting3->description = 'About Us Year';
            $setting3->value = $validated['timeline_year'];
            $setting3->save();

            $setting4 = new Setting();
            $setting4->key = 'ABOUT_US_TIMELINE_DESC' . $count;
            $setting4->type = 'Text';
            $setting4->description = 'About Us Description';
            $setting4->value = $validated['timeline_desc'];
            $setting4->save();

            $setting5 = new Setting();
            $setting5->key = 'ABOUT_US_TIMELINE_IMAGE' . $count;
            $setting5->type = 'Image';
            $setting5->description = 'About Us Image';
            $setting5->value = $filename;
            $setting5->save();

            $activeTab = '#tab-5';

        }

        if(isset($validated['video_link'])){

            $settings = DB::table('settings')->where('key', 'like', 'ABOUT_US_VIDEO_TOUR%')->get();
            $count = $settings->count() + 1;

            // Create new setting entry
            $setting = new Setting();
            $setting->key = 'ABOUT_US_VIDEO_TOUR' . $count;
            $setting->type = 'Text';
            $setting->description = 'About Us Video Tour';
            $setting->value = $validated['video_link'];
            $setting->save();

            $activeTab = '#tab-5';

        }

        return redirect('/admin-control')->with('success_msg', 'About Us Timeline Added Successfully.')->with('active_tab', $activeTab);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $my_user = auth()->user();
        if ($my_user == null) {
            return redirect('/home')->with('error_msg', 'Login First');
        }
        if ($my_user->usertype > 1) {
            return redirect('/home')->with('error_msg', 'Invalid Access!');
        }

        //
        $validated = $request->validate([
            'file' => ['nullable', 'file'], // Max 5MB
            'value' => ['nullable'],
        ]);

        // Get File Name with Extension then store file
        $filename = null;
        if ($request->hasFile('file')) {

            $setting = Setting::find($id);

            $path = null;
            // If setting key has "HOME_" prefix, store in home directory
            if($setting->key && str_starts_with($setting->key, 'HOME_')){
                $path = 'home';
            } 
            elseif($setting->key && str_starts_with($setting->key, 'BULLET_')){
                $path = 'bulletproofing';
            } 
            elseif($setting->key && str_starts_with($setting->key, 'GLASS_MFG_')){
                $path = 'glass-mfg';
            }
            elseif($setting->key && str_starts_with($setting->key, 'ALUMINUM_MFG_')){
                $path = 'aluminum';
            }
            elseif($setting->key && str_starts_with($setting->key, 'GLASS_PRO_')){
                $path = 'glass-processing';
            }
            elseif($setting->key && str_starts_with($setting->key, 'ABOUT_')){
                $path = 'about-us';
            }
            elseif($setting->key && str_starts_with($setting->key, 'NAVBAR_')){
                $path = 'logos';
            }
            elseif($setting->key && str_starts_with($setting->key, 'WELCOME_')){
                $path = 'logos';
            } 
            else {
                $path = 'home';
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs($path, $filename, 'public');

            $setting->value = $filename;
            $setting->save();

            $log = new Log();
            $log->user_id = $my_user->id ?? null;
            $log->action = 'Attempted to update setting with id ' . $setting->id;
            $log->details = 'Updated '. $setting->name .' setting to file ' . $filename . ' ID: ' . $setting->id;
            $log->save();

            return redirect('/admin-control')->with('success_msg', 'Setting updated successfully.');
        }   

        if($request->has('value')){
            $setting = Setting::find($id);
            $setting->value = $request->input('value');
            $setting->save();

            $log = new Log();
            $log->user_id = $my_user->id ?? null;
            $log->action = 'Attempted to update setting with id ' . $setting->id;
            $log->details = 'Updated '. $setting->name .' setting to value ' . $request->input('value') . 'ID: ' . $setting->id;
            $log->save();

            return redirect('/admin-control')->with('success_msg', 'Setting updated successfully.');
        }

        return redirect('/admin-control')->with('error_msg', 'No value provided for update.');
    }

    /**
     * Show the audit trail.
     */
    public function audit()
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $my_user = $auth->user();
        if ($my_user == null) return redirect('/home')->with('error_msg', 'Invalid Access!');
        if ($my_user->usertype > 1) return redirect('/home')->with('error_msg', 'Invalid Access!');

        $logs = Log::join('users', 'logs.user_id', '=', 'users.id')
            ->orderBy('logs.created_at', 'desc')
            ->select(
                'logs.*',
                DB::raw("CONCAT(users.fname, ' ', users.mname, ' ', users.lname) as username")
            )
            ->get();
        
        return view('dashboard.index', [
            'my_user' => $my_user,
            'logs' => $logs,
        ])
        ->with('title', 'Audit Trail')
        ->with('main_content', 'dashboard.settings.audit-trail');
    }
}
