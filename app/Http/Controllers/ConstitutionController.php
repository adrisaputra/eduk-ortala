<?php

namespace App\Http\Controllers;

use App\Models\Constitution;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class ConstitutionController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Undang-undang";
        $constitution = Constitution::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.constitution.index',compact('title','constitution'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Undang-undang";
        $constitution = $request->get('search');
        $constitution = Constitution::where('name', 'LIKE', '%'.$constitution.'%')
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.constitution.index',compact('title','constitution'));
        } else {
            return view('admin.constitution.search',compact('title','constitution'));
        }
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "Undang-undang";
		$view=view('admin.constitution.create',compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:10000'
        ]);

		$constitution = New Constitution();
        $constitution->fill($request->all());

		if($request->file){
			$constitution->file = time().'.'.$request->file->getClientOriginalExtension();
			$request->file->move(public_path('upload/constitution'), $constitution->file);
		}

    	$constitution->save();
        
        activity()->log('Tambah Data Constitution');
		return redirect('/constitution')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($constitution)
    {
        $title = "Undang-undang";
        $constitution = Crypt::decrypt($constitution);
        $constitution = Constitution::where('id',$constitution)->first();
        $view=view('admin.constitution.edit', compact('title','constitution'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $constitution)
    {
        
        $constitution = Crypt::decrypt($constitution);
        $constitution = Constitution::where('id',$constitution)->first();

        $this->validate($request, [
            'name' => 'required',
            'file' => 'mimes:jpg,jpeg,png,pdf|max:10000'
        ]);

        if ($constitution->file && $request->file('file') != "") {
			$file_path = public_path() . '/upload/constitution/' . $constitution->file;
			unlink($file_path);
		}
   
        $constitution->fill($request->all());

		if($request->file('file')){	
			$filename = time().'.'.$request->file->getClientOriginalExtension();
			$request->file->move(public_path('upload/constitution'), $filename);
			$constitution->file = $filename;
		}
		
    	$constitution->save();
		
        activity()->log('Ubah Data Constitution dengan ID = '.$constitution->id);
		return redirect('/constitution')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(Constitution $constitution)
    {
		if($constitution->file){
			$pathToYourFile = public_path('upload/constitution/'.$constitution->file);
			if(file_exists($pathToYourFile))
			{
				unlink($pathToYourFile);
			}
		}

    	$constitution->delete();

        activity()->log('Hapus Data Constitution dengan ID = '.$constitution->id);
        return redirect('/constitution')->with('status', 'Data Berhasil Dihapus');
    }
}
