<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogueController extends Controller
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

        $catalogues = DB::table('catalogues')
            ->where('isDeleted', '=', false)->get();

        return view('dashboard.index', [
            'my_user' => $my_user,
            'title' => 'Catalogue',
            'main_content' => 'dashboard.settings.catalogue',
            'catalogues' => $catalogues,
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
            
        return view('dashboard.settings.catalogue-create', [
            'my_user' => $my_user,
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
            'title' => ['required'],
            'upload_file' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        // Handle file upload
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('catalogue', $filename, 'public');
        } else {
            $filename = "default.png"; 
        }

        $catalogue = new Catalogue();
        $catalogue->title = $validated['title'];
        $catalogue->upload_file = $filename;
        $catalogue->save();

        return redirect('/catalogue')->with('success_msg', 'Catalogue Successfully Created');
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

        $catalogue = DB::table('catalogues')
            ->where('id', '=', $id)
            ->where('isDeleted', '=', false)->get();

        if($catalogue == null || count($catalogue) == 0){
            return redirect('/catalogue')->with('error_msg', 'Unexpected Error!');
        }
 
        return view('dashboard.settings.catalogue-update', [
            'my_user' => $my_user,
            'catalogue' => $catalogue[0],
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
            'title' => ['required'],
            'upload_file' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        $catalogue = Catalogue::find($id);
        $catalogue->title = $validated['title'];
        $filename =  $catalogue->upload_file;

        // Handle file upload
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('catalogue', $filename, 'public');

            if ($catalogue->upload_file != 'default.png') {
                // Delete the image from the filesystem
                if (file_exists(public_path('storage/catalogue/' . $catalogue->upload_file))) {
                    unlink(public_path('storage/catalogue/' . $catalogue->upload_file));
                }
            }
        }

        $catalogue->upload_file = $filename;
        $catalogue->save();

        return redirect('/catalogue')->with('success_msg', 'Catalogue Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $catalogue = Catalogue::find($id);
        $catalogue->isDeleted = true;
        $catalogue->save();

        return redirect('/catalogue')->with('success_msg', 'Catalogue Successfully Deleted');
    }
}
