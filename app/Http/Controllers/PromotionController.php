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
    public function index(Request $request)
    {
        $title = "Naik Pangkat";
        if($request->get('year')){
            $title = "Naik Pangkat";
            $year = $request->get('year');
            $period = $request->get('period');
            $promotion = $request->get('search');
            $promotion = Promotion::
                        where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
            
            $count_promotion_hold = Promotion::
                        whereIn('status',['Hold','Diperbaiki'])
                        ->where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->count();

            $count_promotion_dikirim = Promotion::
                        where('status','Dikirim')
                        ->where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->count();
            
            $count_promotion_accept= Promotion::
                        where('status','Diterima')
                        ->where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->count();
            
            if($request->input('page')){
                return view('admin.promotion.index',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept'));
            } else {
                return view('admin.promotion.index',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept'));
            }
        } else {
            
            return view('admin.promotion.index',compact('title'));
        } 
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Naik Pangkat";
        $year = $request->get('year');
        $period = $request->get('period');
        $promotion = $request->get('search');
        $promotion = Promotion::
                    where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        $count_promotion_hold = Promotion::
                    whereIn('status',['Hold','Diperbaiki'])
                    ->where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->count();

        $count_promotion_dikirim = Promotion::
                    where('status','Dikirim')
                    ->where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->count();

        $count_promotion_accept= Promotion::
                    where('status','Diterima')
                    ->where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->count();

        if($request->input('page')){
            return view('admin.promotion.index',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept'));
        } else {
            return view('admin.promotion.search',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept'));
        }
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
		return redirect('/promotion?year='.$request->year.'&&period='.$request->period)->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($promotion)
    {
        $title = "Naik Pangkat";
        $employee = Employee::get();
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();
        $view=view('admin.promotion.edit', compact('title','employee','promotion'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $promotion)
    {
        
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();

        $this->validate($request, [
            'employee_id' => 'required',
            'promotion_type' => 'required'
        ]);

        
        $employee = Employee::where('id',$request->employee_id)->first();
        $promotion->fill($request->all());
        $promotion->nip = $employee->nip;
    	$promotion->save();
		
        activity()->log('Ubah Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion?year='.$request->year.'&&period='.$request->period)->with('status','Data Diubah');
    }

    ## Hapus Data
    public function delete(Promotion $promotion)
    {
    	$promotion->delete();

        activity()->log('Hapus Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion?year='.$promotion->year.'&&period='.$promotion->period)->with('status','Data Dihapus');
    }

    ## Kirim Pengajuan
    public function send($year, $period, Request $request)
    {
        $promotion = Promotion::where('year',$year)->where('period',$period)->get();

        foreach($promotion as $v){
            $promotion = Promotion::where('id',$v->id)->first();
            if($request->segment(2)=="send"){
                $promotion->status = "Dikirim";
            } elseif($request->segment(2)=="accept"){
                $promotion->status = "Diterima";
            } elseif($request->segment(2)=="reject"){
                $promotion->status = "Ditolak";
            }
            $promotion->save();
        }
		
        activity()->log('Kirim Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion?search=&&year='.$year.'&&period='.$period)->with('status', 'Data Berhasil Dikirim');
    }

    ## Kirim Pengajuan
    public function process($promotion, Request $request)
    {
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();

        if($request->segment(2)=="accept"){
            $promotion->status = "Diterima";
        } elseif($request->segment(2)=="reject"){
            $promotion->status = "Ditolak";
        }
        $promotion->save();
		
        activity()->log('Kirim Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion?search=&&year='.$promotion->year.'&&period='.$promotion->period)->with('status', 'Data Berhasil Dikirim');
    }

    ## Kirim Pengajuan
    public function fix_document($promotion, Request $request)
    {
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();

        $promotion->status = "Diperbaiki";
        $promotion->note = $request->note;
    	$promotion->save();
		
        activity()->log('Kirim Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion?search=&&year='.$promotion->year.'&&period='.$promotion->period)->with('status', 'Data Berhasil Dikirim');
    }
}
