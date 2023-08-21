<?php

namespace App\Http\Controllers;

use App\Models\ParentUnit;   //nama model
use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\SalaryIncrease;
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

        foreach($parent_unit as $i => $v){
            $promotion[$i] = Promotion::where('parent_unit_id', $v->id)
                            ->where('status','Dikirim')
                            ->groupBy('year','period')->count();
            $salary_increase[$i] = SalaryIncrease::where('parent_unit_id', $v->id)
                                ->where('status','Dikirim')->count();
        }
        return view('admin.parent_unit.index',compact('title','parent_unit','promotion','salary_increase'));
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
        
        foreach($parent_unit as $i => $v){
            $promotion[$i] = Promotion::where('parent_unit_id', $v->id)
                            ->where('status','Dikirim')
                            ->groupBy('year','period')->count();
        }

        if($request->input('page')){
            return view('admin.parent_unit.index',compact('title','parent_unit','promotion'));
        } else {
            return view('admin.parent_unit.search',compact('title','parent_unit','promotion'));
        }
    }
}
