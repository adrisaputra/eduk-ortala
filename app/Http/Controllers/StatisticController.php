<?php

namespace App\Http\Controllers;

use App\Models\ParentUnit;   //nama model
use App\Models\Employee;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class StatisticController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function number_of_employees(Request $request)
    {
        if (Auth::user()->group_id == 1) {
            $title = "JUMLAH PEGAWAI KESELURUHAN";
            $male = Employee::where('gender','LAKI-LAKI')->count();
            $female = Employee::where('gender','PEREMPUAN')->count();
            $max_value = max($male, $female);
            return view('admin.statistic.number_of_employees',compact('title','male','female','max_value'));
        } else {
            $parent_unit = ParentUnit::where('id', Auth::user()->parent_unit_id)->first();
            $title = "JUMLAH PEGAWAI ( ".$parent_unit->name." )";
            $male = Employee::where('gender','LAKI-LAKI')->where('parent_unit_id', Auth::user()->parent_unit_id)->count();
            $female = Employee::where('gender','PEREMPUAN')->where('parent_unit_id', Auth::user()->parent_unit_id)->count();
            $max_value = max($male, $female);
            return view('admin.statistic.number_of_employees',compact('title','male','female','max_value'));
        }
    }

    ## Tampikan Data
    public function number_of_class(Request $request)
    {
        if (Auth::user()->group_id == 1) {
            $title = "JUMLAH PEGAWAI PER GOLONGAN";
            $class_1 = Employee::whereIn('class_id',[1,2,3,4])->count();
            $class_2 = Employee::whereIn('class_id',[5,6,7,8])->count();
            $class_3 = Employee::whereIn('class_id',[9,10,11,12])->count();
            $class_4 = Employee::whereIn('class_id',[13,14,15,16,17])->count();
            $max_value = max($class_1, $class_2, $class_3, $class_4);
            return view('admin.statistic.number_of_class',compact('title','class_1','class_2','class_3','class_4','max_value'));
        } else {
            $parent_unit = ParentUnit::where('id', Auth::user()->parent_unit_id)->first();
            $title = "JUMLAH PEGAWAI PER GOLONGAN ( ".$parent_unit->name." )";
            $class_1 = Employee::whereIn('class_id',[1,2,3,4])->where('parent_unit_id', Auth::user()->parent_unit_id)->count();
            $class_2 = Employee::whereIn('class_id',[5,6,7,8])->where('parent_unit_id', Auth::user()->parent_unit_id)->count();
            $class_3 = Employee::whereIn('class_id',[9,10,11,12])->where('parent_unit_id', Auth::user()->parent_unit_id)->count();
            $class_4 = Employee::whereIn('class_id',[13,14,15,16,17])->where('parent_unit_id', Auth::user()->parent_unit_id)->count();
            $max_value = max($class_1, $class_2, $class_3, $class_4);
            return view('admin.statistic.number_of_class',compact('title','class_1','class_2','class_3','class_4','max_value'));
        }
    }
    
}
