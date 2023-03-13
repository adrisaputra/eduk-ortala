<?php

namespace App\Http\Controllers;

use App\Models\Office;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class OfficeController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "OPD";
        $office = Office::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.office.index',compact('title','office'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "OPD";
        $office = $request->get('search');
        $office = Office::where('office_name', 'LIKE', '%'.$office.'%')
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        return view('admin.office.index',compact('title','office'));
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "OPD";
		$view=view('admin.office.create',compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'office_name' => 'required',
        ]);

		$input['office_name'] = $request->office_name;
		$input['office_address'] = $request->office_address;
		
        Office::create($input);
        
        activity()->log('Tambah Data Office');
		return redirect('/office')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($office)
    {
        $title = "OPD";
        $office = Crypt::decrypt($office);
        $office = Office::where('id',$office)->first();
        $view=view('admin.office.edit', compact('title','office'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $office)
    {
        
        $office = Crypt::decrypt($office);
        $office = Office::where('id',$office)->first();

        $this->validate($request, [
            'office_name' => 'required',
        ]);

        $office->fill($request->all());
    	$office->save();
		
        activity()->log('Ubah Data Office dengan ID = '.$office->id);
		return redirect('/office')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($office)
    {
        $office = Crypt::decrypt($office);
        $office = Office::where('id',$office)->first();
    	$office->delete();

        activity()->log('Hapus Data Office dengan ID = '.$office->id);
        return redirect('/office')->with('status', 'Data Berhasil Dihapus');
    }
}
