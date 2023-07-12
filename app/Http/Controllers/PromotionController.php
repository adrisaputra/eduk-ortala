<?php

namespace App\Http\Controllers;

use App\Models\Promotion;   //nama model
use App\Models\Employee;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class PromotionController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Naik Pangkat";
        if(Auth::user()->group_id==1){
            $promotion = Promotion::whereNotIn('status',['Hold'])->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        }else{
            $promotion = Promotion::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        }
        return view('admin.promotion.index',compact('title','promotion'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Naik Pangkat";
        $promotion = $request->get('search');
        $promotion = Promotion::where('promotion_name', 'LIKE', '%'.$promotion.'%')
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        return view('admin.promotion.index',compact('title','promotion'));
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "Naik Pangkat";
        $employee = Employee::get();
		$view=view('admin.promotion.create',compact('title','employee'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required',
            'promotion_type' => 'required'
        ]);

		$promotion = New Promotion();
        
        $employee = Employee::where('id',$request->employee_id)->first();
        $promotion->fill($request->all());
        $promotion->nip = $employee->nip;
    	$promotion->save();
        
        activity()->log('Tambah Data Promotion');
		return redirect('/promotion')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($promotion)
    {
        $title = "Naik Pangkat";
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();
        $view=view('admin.promotion.edit', compact('title','promotion'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $promotion)
    {
        
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();

        $this->validate($request, [
            'promotion_name' => 'required',
        ]);

        $promotion->fill($request->all());
    	$promotion->save();
		
        activity()->log('Ubah Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($promotion)
    {
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();
    	$promotion->delete();

        activity()->log('Hapus Data Promotion dengan ID = '.$promotion->id);
        return redirect('/promotion')->with('status', 'Data Berhasil Dihapus');
    }

    ## Kirim Pengajuan
    public function process($promotion, Request $request)
    {
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();

        if($request->segment(2)=="send"){
            $promotion->status = "Dikirim";
        } elseif($request->segment(2)=="accept"){
            $promotion->status = "Diterima";
        } elseif($request->segment(2)=="reject"){
            $promotion->status = "Ditolak";
        }
    	$promotion->save();
		
        activity()->log('Kirim Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion')->with('status', 'Data Berhasil Dikirim');
    }
}
