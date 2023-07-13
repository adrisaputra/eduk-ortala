<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\User;   //nama model

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
        $user = User::count();
        $employee = Employee::whereIn("status",['PNS', 'CPNS'])->count();
        return view('admin.home', compact('user','employee'));
    }
}
