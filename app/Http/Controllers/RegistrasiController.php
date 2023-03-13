<?php

namespace App\Http\Controllers;

use App\Models\User;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    public function registrasi()
    {
        $title = 'Registrasi';
        return view('auth.register', compact('title'));
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

		$input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['password'] = Hash::make($request->password);
        $input['status'] = 1;
        $input['group_id'] = 2;
        
        User::create($input);

		// return redirect('/')->with('status2','Registrasi Berhasil, Silahkan Login !');
		return redirect('/')->with('status2','Registrasi Berhasil, Periksa email Anda untuk tautan verifikasi !');

    }

}
