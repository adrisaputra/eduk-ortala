<?php

namespace App\Http\Controllers;

use App\Models\ParentUnit;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class ParentUnitController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index(Request $request)
    {
        $title = "Unor Induk";
        $parent_unit = ParentUnit::Sorting()->Pagination();
        return view('admin.parent_unit.index',compact('title','parent_unit'));
    }

    ## Tampilkan Data Search
    public function search(Request $request)
    {
        $title = "Unit Induk";
        $parent_unit = $request->get('search');
        $parent_unit = ParentUnit::
                where(function ($query) use ($parent_unit) {
                    $query->where('name', 'LIKE', '%'.$parent_unit.'%');
                })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.parent_unit.index',compact('title','parent_unit'));
        } else {
            return view('admin.parent_unit.search',compact('title','parent_unit'));
        }
    }
}
