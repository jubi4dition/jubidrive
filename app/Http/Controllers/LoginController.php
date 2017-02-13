<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /**
     * Show the login page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login');
    }
    
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), ['username' => 'required', 'password' => 'required']);
        
        if ($validator->fails()) {
            return view('login');
        }
        
        if (\Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {
            return redirect()->intended('/');
        }
        
        return view('login');
    }
}
