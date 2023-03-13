<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DatabaseController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
        $title = "Database";
        return view('admin.database.index',compact('title'));
    }

    ## Simpan Data
    public function store(Request $request)
    {
        
		if($request->file('file_sql')){
			$input['file_sql'] = 'import.'.$request->file_sql->getClientOriginalExtension();
			$request->file_sql->move(public_path('db_import'), $input['file_sql']);
    	}	

        \Artisan::call("database:import");
        activity()->log('Import File SQL');
        return redirect('/database')->with('status', 'Data Tersimpan');
    }
}
