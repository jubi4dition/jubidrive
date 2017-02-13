<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator, Auth, Storage;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $users = \App\User::all()->except(Auth::id());
        
        return view('people')->with('users', $users);
    }
    
    /**
     * Update the password of the user.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function password(Request $request)
    {
        if ($request->input('password') === null || $request->input('password_repeat') === null) {
            return redirect()->route('settings');
        }
        
        if ($request->input('password') !== $request->input('password_repeat')) {
            return redirect()->route('settings');
        }
        
        $user = Auth::user();
        $user->password = \Hash::make($request->input('password'));
        $user->save();
        
        return redirect()->route('settings');
    }
    
    /**
     * Update the photo of the user.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function photo(Request $request)
    {
        if ($request->file('file') === null) {
            abort(404);
        }
        
        $uploadedFile = $request->file('file');
        
        $uploadedFilePath = $uploadedFile->store('userphotos', 'public');
        
        $user = Auth::user();
        
        if ($user->photo !== null) {
            Storage::disk('public')->delete('userphotos/'.$user->photo);
        }
        
        $user->photo = $uploadedFile->hashName();
        $user->save();
        
        return redirect()->route('settings');
    }
    
    /**
     * Show the settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        return view('settings')->with('photo', Auth::user()->photoURL());
    }
}
