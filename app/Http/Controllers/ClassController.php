<?php

namespace App\Http\Controllers;

use App\Models\Classes;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class ClassController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Golongan";
        $class = Classes::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.class.index',compact('title','class'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Golongan";
        $class = $request->get('search');
        $class = Classes::where('name', 'LIKE', '%'.$class.'%')
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        return view('admin.class.index',compact('title','class'));
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "Golongan";
		$view=view('admin.class.create',compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|numeric|digits:2',
            'class' => 'required|string',
            'rank' => 'required|string',
        ]);

        $class = New Classes();
        $class->fill($request->all());
    	$class->save();
        
        activity()->log('Tambah Data Golongan');
		return redirect('/class')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($class)
    {
        $title = "Golongan";
        $class = Crypt::decrypt($class);
        $class = Classes::where('id',$class)->first();
        $view=view('admin.class.edit', compact('title','class'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $class)
    {
        
        $class = Crypt::decrypt($class);
        $class = Classes::where('id',$class)->first();

        $this->validate($request, [
            'code' => 'required|numeric|digits:2',
            'class' => 'required|string',
            'rank' => 'required|string',
        ]);

        $class->fill($request->all());
    	$class->save();
		
        activity()->log('Ubah Data Golongan dengan ID = '.$class->id);
		return redirect('/class')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($class)
    {
        $class = Crypt::decrypt($class);
        $class = Classes::where('id',$class)->first();
    	$class->delete();

        activity()->log('Hapus Data Golongan dengan ID = '.$class->id);
        return redirect('/class')->with('status', 'Data Berhasil Dihapus');
    }
}
