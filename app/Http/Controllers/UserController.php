<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller{
    
    public function showRegistrationForm(){
        return view('register');
    }

    public function register(Request $request){
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success');
    }

    public function showLoginForm(){
        return view('login');
    }

    public function login(Request $request){
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        return redirect('/login')->with('error', 'Invalid credentials');
    }

    public function ChangePasswordForm(){
        return view('changepassword');
    }

    public function changepassword(Request $request){
        $request->validate([
            'username'=>'required',
            'email'=>'required|email',
            'password'=>'required',
        ]);
        
        $user = User::where('username', $request->username)
                ->where('email', $request->email)
                ->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect('/login')->with('success');
        }

        return redirect()->back()->with('error');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}