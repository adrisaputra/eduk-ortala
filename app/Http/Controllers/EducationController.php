<?php

namespace App\Http\Controllers;

use App\Models\Education;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class EducationController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Pendidikan";
        $education = Education::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.education.index',compact('title','education'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Pendidikan";
        $education = $request->get('search');
        $education = Education::where('name', 'LIKE', '%'.$education.'%')
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        return view('admin.education.index',compact('title','education'));
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "Pendidikan";
		$view=view('admin.education.create',compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|numeric',
            'name' => 'required|string',
            'level_code' => 'required|numeric|digits:2',
        ]);

        $education = New Education();
        $education->fill($request->all());
    	$education->save();
        
        activity()->log('Tambah Data Pendidikan');
		return redirect('/education')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($education)
    {
        $title = "Pendidikan";
        $education = Crypt::decrypt($education);
        $education = Education::where('id',$education)->first();
        $view=view('admin.education.edit', compact('title','education'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $education)
    {
        
        $education = Crypt::decrypt($education);
        $education = Education::where('id',$education)->first();

        $this->validate($request, [
            'code' => 'required|numeric',
            'name' => 'required|string',
            'level_code' => 'required|numeric|digits:2',
        ]);

        $education->fill($request->all());
    	$education->save();
		
        activity()->log('Ubah Data Pendidikan dengan ID = '.$education->id);
		return redirect('/education')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($education)
    {
        $education = Crypt::decrypt($education);
        $education = Education::where('id',$education)->first();
    	$education->delete();

        activity()->log('Hapus Data Pendidikan dengan ID = '.$education->id);
        return redirect('/education')->with('status', 'Data Berhasil Dihapus');
    }
}
