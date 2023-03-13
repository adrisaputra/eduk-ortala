<?php

namespace App\Http\Controllers;

use App\Models\Vision;   //nama model
use App\Models\Mission;   //nama model
use App\Models\Purpose;   //nama model
use App\Models\GoalIndicator;   //nama model
use App\Models\Target;   //nama model
use App\Models\Program;   //nama model
use App\Models\Activity;   //nama model
use App\Models\SubActivity;   //nama model
use App\Models\Office;   //nama model
use App\Models\User;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
        if(Auth::user()->group_id == 1){
            $user = User::count();
            return view('admin.home', compact('user'));
        } else {
            $user = User::count();
            return view('admin.home', compact('user'));
        }
    }
}
