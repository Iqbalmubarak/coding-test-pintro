<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;

class LoginController extends Controller
{
    public function showLoginForm(){
        if(Sentinel::check()){
            return redirect()->route('home.dashboard');
        }else{
            return view('auth.login');
        }
    }

    protected function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        //dd($request);
        try {
            Sentinel::authenticate($request->all());
            if(Sentinel::check()){
                return redirect()->route('inventory.index')->with('success', 'Login success');
            }else{
                return redirect()->back()->with('error', 'Email/ password yang anda masukkan salah');
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back();
        }

    }

    public function logout(){
        try {
            Sentinel::logout();

            return redirect()->route('login');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
}
