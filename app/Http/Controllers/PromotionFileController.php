<?php

namespace App\Http\Controllers;

use App\Models\PromotionFile;   //promotion model
use App\Models\Promotion;   //promotion model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PromotionFileController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($promotion)
    {
        $title = "File Pendukung";
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();
        $promotion_file = PromotionFile::Promotion($promotion->id)->Sorting()->Pagination();
        return view('admin.promotion_file.index',compact('title','promotion','promotion_file'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $promotion)
    {
        $title = "File Pendukung";
        $promotion = Crypt::decrypt($promotion);
        $promotion_file = $request->get('search');
        $promotion_file = PromotionFile::Promotion($promotion)->Keyword($promotion_file)->Sorting()->Pagination();
        
        if($request->input('page')){
            return view('admin.promotion_file.index',compact('title','promotion_file'));
        } else {
            return view('admin.promotion_file.search',compact('title','promotion_file'));
        }
    }
    
    ## Tampilkan Form Create
    public function create($promotion)
    {
        $title = "File Pendukung";
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();
        $view=view('admin.promotion_file.create',compact('title','promotion'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request, $promotion)
    {
        $this->validate($request, [
            'name' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:10000'
        ]);

        $promotion_file = new PromotionFile();
        $promotion_file->fill($request->all());
        $promotion_file->promotion_id = Crypt::decrypt($promotion);
        
		if($request->file){
			$promotion_file->file = time().'.'.$request->file->getClientOriginalExtension();
			$request->file->move(public_path('upload/promotion_file'), $promotion_file->file);
		}

        $promotion_file->save();

        activity()->log('Create PromotionFile');
        return redirect('/promotion_file/'.$promotion)->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($promotion, $promotion_file)
    {
        $title = "File Pendukung";
        
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();

        $promotion_file = Crypt::decrypt($promotion_file);
        $promotion_file = PromotionFile::where('id',$promotion_file)->first();
        $view=view('admin.promotion_file.edit', compact('title','promotion','promotion_file'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $promotion, $promotion_file)
    {
        
        $promotion_file = Crypt::decrypt($promotion_file);
        $promotion_file = PromotionFile::where('id',$promotion_file)->first();

        $this->validate($request, [
            'name' => 'required',
            'file' => 'mimes:jpg,jpeg,png,pdf|max:10000'
        ]);

        if ($promotion_file->file && $request->file('file') != "") {
			$file_path = public_path() . '/upload/promotion_file/' . $promotion_file->file;
			unlink($file_path);
		}
   
        $promotion_file->fill($request->all());

		if($request->file('file')){	
			$filename = time().'.'.$request->file->getClientOriginalExtension();
			$request->file->move(public_path('upload/promotion_file'), $filename);
			$promotion_file->file = $filename;
		}
		
        $promotion_file->save();
        
        activity()->log('Update PromotionFile with ID = '.$promotion_file->id);
        return redirect('/promotion_file/'.$promotion)->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($promotion, PromotionFile $promotion_file)
    {
        
        $promotion = Crypt::encrypt($promotion);

        $promotion_file->delete();
        activity()->log('Delete PromotionFile with ID = '.$promotion_file->id);
        return redirect('/promotion_file/'.$promotion)->with('status', 'Data Berhasil Dihapus');
    }
}
