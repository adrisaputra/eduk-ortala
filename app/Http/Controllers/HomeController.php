<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\User;   //nama model
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
        $user = User::count();
        if(Auth::user()->group_id==1){
            $employee = Employee::whereIn("status",['PNS', 'CPNS'])->count();
        } else {
            $employee = Employee::whereIn("status",['PNS', 'CPNS'])->where('parent_unit_id', Auth::user()->parent_unit_id)->count();
        }
        return view('admin.home', compact('user','employee'));
    }
}
