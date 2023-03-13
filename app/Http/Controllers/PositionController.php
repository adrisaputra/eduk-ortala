<?php

namespace App\Http\Controllers;

use App\Models\Position;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class PositionController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index()
    {
        $title = "Jabatan";
        $position = Position::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.position.index',compact('title','position'));
    }

    ## Tampilkan Data Search
    public function search(Request $request)
    {
        $title = "Jabatan";
        $position = $request->get('search');
        $position = Position::where('name', 'LIKE', '%'.$position.'%')
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        return view('admin.position.index',compact('title','position'));
    }
    
    ## Tampilkan Form Create
    public function create()
    {
        $title = "Jabatan";
        $view=view('admin.position.create',compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        $position = New Position();
        $position->fill($request->all());
        $position->save();
        
        activity()->log('Tambah Data Jabatan');
        return redirect('/position')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($position)
    {
        $title = "Jabatan";
        $position = Crypt::decrypt($position);
        $position = Position::where('id',$position)->first();
        $view=view('admin.position.edit', compact('title','position'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $position)
    {
        
        $position = Crypt::decrypt($position);
        $position = Position::where('id',$position)->first();

        $this->validate($request, [
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        $position->fill($request->all());
        $position->save();
        
        activity()->log('Ubah Data Jabatan dengan ID = '.$position->id);
        return redirect('/position')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($position)
    {
        $position = Crypt::decrypt($position);
        $position = Position::where('id',$position)->first();
        $position->delete();

        activity()->log('Hapus Data Jabatan dengan ID = '.$position->id);
        return redirect('/position')->with('status', 'Data Berhasil Dihapus');
    }
}
