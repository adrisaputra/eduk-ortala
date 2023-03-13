<?php

namespace App\Http\Controllers;

use App\Models\Slider;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class SliderController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Slider";
        $slider = Slider::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.slider.index',compact('title','slider'));
    }

    ## Tampilkan Form Create
    public function create()
    {
        $title = "Slider";
		$view=view('admin.slider.create',compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);

        $slider = new Slider();

        $slider->image = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('upload/slider'),  $slider->image);
		
        $slider->save();
        
        activity()->log('Tambah Data Slider');
		return redirect('/slider')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($slider)
    {
        $title = "Slider";
        $slider = Crypt::decrypt($slider);
        $slider = Slider::where('id',$slider)->first();
        $view=view('admin.slider.edit', compact('title','slider'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $slider)
    {
        
        $slider = Crypt::decrypt($slider);
        $slider = Slider::where('id',$slider)->first();

        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);

		if($request->file('image') && $slider->image){
			$pathToYourFile = public_path('upload/slider/'.$slider->image);
			if(file_exists($pathToYourFile))
			{
				unlink($pathToYourFile);
			}
		}

        $slider->fill($request->all());
        
		if($request->file('image')){
			$filename = time().'.'.$request->image->getClientOriginalExtension();
			$request->image->move(public_path('upload/slider'), $filename);
			$slider->image = $filename;
		 }
			
    	$slider->save();
		
        activity()->log('Ubah Data Slider dengan ID = '.$slider->id);
		return redirect('/slider')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($slider)
    {
        $slider = Crypt::decrypt($slider);
        $slider = Slider::where('id',$slider)->first();
        
		if($slider->image){
			$pathToYourFile = public_path('upload/slider/'.$slider->image);
			if(file_exists($pathToYourFile))
			{
				unlink($pathToYourFile);
			}
		}

    	$slider->delete();

        activity()->log('Hapus Data Slider dengan ID = '.$slider->id);
        return redirect('/slider')->with('status', 'Data Berhasil Dihapus');
    }
}
