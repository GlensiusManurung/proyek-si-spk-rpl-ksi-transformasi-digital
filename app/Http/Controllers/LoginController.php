<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('halamanlogin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $user = Auth::user();

            // ✅ SET STATUS ONLINE
            $user->is_online = true;
            $user->save();

            if($user->nama !== $request->nama){
                Auth::logout();
                return back()->with('error','Nama tidak sesuai');
            }

            if($user->role == 'superadmin'){
                return redirect()->route('superadmin.dashboard'); 
            }
            if($user->role == 'admin'){
                return redirect('/admin/dashboard'); 
            }
            if($user->role == 'driver'){
                return redirect('/driver/dashboard'); 
            }
        }

        return back()->with('error','Email atau Password salah');
    }

    public function logout(Request $request)
    {
        // ✅ SET STATUS OFFLINE
        if (Auth::check()) {
            $user = Auth::user();
            $user->is_online = false;
            $user->save();
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}