<?php

namespace App\Http\Controllers;

use App\Models\Unit;   //nama model
use App\Models\Employee;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DukController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }

    ## Tampikan Data
    public function index()
    {
        $title = "DUK";
        $unit = Unit::orderBy('id','DESC')->get();
        $employee = Employee::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $masa_kerja = array();
        $usia = array();

        foreach($employee as $i => $v){
            if($v->class_history_first($v->nip)->first()){
                $masa_kerja[$i] = $this->hitungSelisihBulan($v->class_history_first($v->nip)->first()->tmt);
            } else {
                $masa_kerja[$i]['tahun'] = "-";
                $masa_kerja[$i]['bulan'] = "-";
            }
            $usia[$i] = $this->hitungUsia($v->date_of_birth);
        }

        return view('admin.duk.index',compact('title','unit','employee','masa_kerja','usia'));

    }

    ## Tampilkan Data Search
    public function search(Request $request)
    {
        $title = "Unit Organisasi";
        $unit = Unit::orderBy('id','DESC')->get();
        $employee = $request->get('search');
        $employee = Employee::
                where(function ($query) use ($employee) {
                    $query->where('nip', 'LIKE', '%'.$employee.'%')
                        ->orWhere('name', 'LIKE', '%'.$employee.'%');
                })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
                
        foreach($employee as $i => $v){
            if($v->class_history_first($v->nip)->first()){
                $masa_kerja[$i] = $this->hitungSelisihBulan($v->class_history_first($v->nip)->first()->tmt);
            } else {
                $masa_kerja[$i]['tahun'] = "-";
                $masa_kerja[$i]['bulan'] = "-";
            }
            $usia[$i] = $this->hitungUsia($v->date_of_birth);
        }
        
        if($request->input('page')){
            return view('admin.duk.index',compact('title','unit','employee','masa_kerja','usia'));
        } else {
            return view('admin.duk.search',compact('title','unit','employee','masa_kerja','usia'));
        }
    }


    function hitungSelisihBulan($tanggalAkhir)
    {
        $res = array();

        $awal = Carbon::now()->startOfMonth();
        $akhir = Carbon::parse($tanggalAkhir)->startOfMonth();

        $selisih = $akhir->diffInMonths($awal);

        $selisihTahun = floor($selisih / 12);
        $selisihBulan = $selisih % 12;

        $res['tahun'] = $selisihTahun;
        $res['bulan'] = $selisihBulan;

        return $res;
    }

    function hitungUsia($tanggalLahir)
    {
        $tanggalLahir = Carbon::parse($tanggalLahir);
        $usia = $tanggalLahir->age;

        return $usia;
    }

}
