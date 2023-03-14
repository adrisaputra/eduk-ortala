<?php

namespace App\Http\Controllers;

use App\Models\Unit;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;


class UnitController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index()
    {
        $title = "Unit Organisasi";
        $unit = Unit::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.unit.index',compact('title','unit'));
    }

    ## Tampilkan Data Search
    public function search(Request $request)
    {
        $title = "Unit Organisasi";
        $unit = $request->get('search');
        $unit = Unit::where('name', 'LIKE', '%'.$unit.'%')
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        return view('admin.unit.index',compact('title','unit'));
    }
    
    ## Tampilkan Form Create
    public function create()
    {
        $title = "Unit Organisasi";
        $get_unit = Unit::get();
        $view=view('admin.unit.create',compact('title', 'get_unit'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string',
            'name' => 'required|string'
        ]);

        $unit = New Unit();
        $unit->fill($request->all());
        $unit->save();
        
        activity()->log('Tambah Data Unit Organisasi');
        return redirect('/unit')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($unit)
    {
        $title = "Unit Organisasi";
        $unit = Crypt::decrypt($unit);
        $unit = Unit::where('id',$unit)->first();
        $get_unit = Unit::get();
        $view=view('admin.unit.edit', compact('title','unit','get_unit'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $unit)
    {
        
        $unit = Crypt::decrypt($unit);
        $unit = Unit::where('id',$unit)->first();

        $this->validate($request, [
            'code' => 'required|string',
            'name' => 'required|string'
        ]);

        $unit->fill($request->all());
        $unit->save();
        
        activity()->log('Ubah Data Unit Organisasi dengan ID = '.$unit->id);
        return redirect('/unit')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($unit)
    {
        $unit = Crypt::decrypt($unit);
        $unit = Unit::where('id',$unit)->first();
        $unit->delete();

        activity()->log('Hapus Data Unit Organisasi dengan ID = '.$unit->id);
        return redirect('/unit')->with('status', 'Data Berhasil Dihapus');
    }
}
