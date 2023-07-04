<?php

namespace App\Http\Controllers;

use App\Models\Log;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Log";
        if(Auth::user()->group_id == 1){
            $log = Log::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        } else {
            $log = Log::where('causer_id', Auth::user()->id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        }
        return view('admin.log.index',compact('title','log'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Log";
        $log = $request->get('search');

        if(Auth::user()->group_id == 1){
            $log =  Log::where(function ($query) use ($log) {
                        $query->where(function ($query) use ($log) {
                            $query->where('description', 'LIKE', '%'.$log.'%');
                        })
                        ->orwhereHas('user', function ($query) use ($log) {
                            $query->where('name', 'LIKE', '%'. $log .'%');
                        });
                    })->orderBy('activity_log.id','DESC')->paginate(25)->onEachSide(1);
        } else {
            $log =  Log::where('causer_id', Auth::user()->id)
                    ->where(function ($query) use ($log) {
                        $query->where(function ($query) use ($log) {
                            $query->where('description', 'LIKE', '%'.$log.'%');
                        })
                        ->orwhereHas('user', function ($query) use ($log) {
                            $query->where('name', 'LIKE', '%'. $log .'%');
                        });
                    })->orderBy('activity_log.id','DESC')->paginate(25)->onEachSide(1);
        }
        
        
        if($request->input('page')){
            return view('admin.log.index',compact('title','log'));
        } else {
            return view('admin.log.search',compact('title','log'));
        }
    }
}
