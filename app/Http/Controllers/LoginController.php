<?php

namespace App\Http\Controllers;

use App\Models\User;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    
    public function index(){

        if (Auth::user() == TRUE) {
            return redirect('/dashboard');
        } else {
            return view('auth.login');
        }

    }
    
    public function authenticate(Request $request){

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && \Hash::check($request->password, $user->password) && $user->status == 1) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Jika berhasil login

                activity()->log('Login');
                return redirect('/dashboard');
            } 
        } else if ($user && \Hash::check($request->password, $user->password) && $user->status == 0) {
            return redirect('/')->with('status2','User Tidak Aktif, Silahkan Hubungi Admin !');
        } else {
            return redirect('/')->with('status2','Nama User atau Password Tidak Sesuai !');
        }

    }

    public function logout(Request $request)
    {
       activity()->log('Log Out');
       Auth::logout();
       $request->session()->invalidate();
    
       $request->session()->regenerateToken();
       Session::flush();
       return redirect('login')->withSuccess('Terimakasih, selamat datang kembali!');
    }
}
