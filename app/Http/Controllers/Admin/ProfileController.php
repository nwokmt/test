<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use Illuminate\Support\facades\Auth;

class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.profile');
    }

    public function edit(Request $request)
    {
        $this->validate($request, Profile::$rules);
        $profiles = new Profile;
        $form = $request->all();
 
        unset($form['_token']);
        unset($form['image']);

        $profiles->fill($form);
        $profiles->save();
        
        return redirect('admin/profile');
    }

    public function front(Request $request)
   {
	$id = Auth::id();
	$profiles = Profile::find($request->user_id = $id);

	return view('admin.profile.front', ['profiles' => $profiles]);

     }
}
