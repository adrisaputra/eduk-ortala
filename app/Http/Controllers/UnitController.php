<?php

namespace App\Http\Controllers;

use App\Models\Unit;   //nama model
use App\Models\ParentUnit;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;


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
        $unit = Unit::
                where(function ($query) use ($unit) {
                    $query->where('code', 'LIKE', '%'.$unit.'%')
                        ->orWhere('name', 'LIKE', '%'.$unit.'%')
                        ->orWhere('parent_code', 'LIKE', '%'.$unit.'%')
                        ->orWhere('leader_code', 'LIKE', '%'.$unit.'%');
                })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.unit.index',compact('title','unit'));
        } else {
            return view('admin.unit.search',compact('title','unit'));
        }
    }
     

	## Tampilkan Form Create
    public function sync()
    {
       // Tarik data dari API
       $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_all_unor');

       // Menguraikan JSON menjadi array asosiatif
       $responseArray = json_decode($response, true);

       // Memeriksa apakah status bernilai true
       if ($responseArray['status']) {
           $data = $responseArray['data'];

           // Mengambil nilai NIP dari setiap objek dalam array data
           // $nips = array_column($data, 'NIP');

           // Menentukan ukuran setiap halaman (misalnya, 50 data per halaman)
           $perPage = 25;

           // Memecah data menjadi halaman-halaman yang lebih kecil
           $pages = array_chunk($data, $perPage);

           // Menampilkan nilai NIP dan Nama per halaman
           foreach ($pages as $page) {
               foreach ($page as $item) {

                   $unit = Unit::where('code',$item['KdUnor'])->first();

                   if($unit == NULL){
                        $unit = New Unit();
                   }

                   $unit->code =  $item['KdUnor'];
                   $unit->name =  $item['NamaUnor'];
                   $unit->parent_code =  $item['UnorInduk'];
                   $unit->leader_code =  $item['UnorAtasan'];
                   $unit->leader_eselon =  $item['Eselon'];
                   $unit->leader_nip =  $item['NIP'];
                   $unit->leader_name =  $item['NamaPim'];
                   $unit->leader_call =  $item['KetPanggil'];
                   $unit->type_unit =  $item['JenisUnor'];
                   $unit->save();
               }
           }

           $unit = Unit::groupBy('parent_code')->orderBy('parent_code','ASC')->get();

           foreach($unit as $v){
                $unit = Unit::where('code',$v->parent_code)->first();
                $parent_unit = ParentUnit::where('code',$v->parent_code)->first();
                if($parent_unit == NULL){
                    $parent_unit = new ParentUnit();
                }
                $parent_unit->code = $unit->code;
                $parent_unit->name = $unit->name;
                $parent_unit->leader_eselon =  $unit->leader_eselon;
                $parent_unit->leader_nip =  $unit->leader_nip;
                $parent_unit->leader_name =  $unit->leader_name;
                $parent_unit->leader_call =  $unit->leader_call;
                $parent_unit->type_unit =  $unit->type_unit;
                $parent_unit->save();
           }

           $unit = Unit::get();
           
           foreach($unit as $v){
                $parent_unit = ParentUnit::where('code',$v->parent_code)->first();
                $unit = Unit::where('id',$v->id)->first();
                $unit->parent_unit_id = $parent_unit->id;
                $unit->save();
            }


           activity()->log('Sinkronisasi Data Class');
           return redirect('/unit')->with('status', 'Data Berhasil Disinkronisasi');
       } else {
           // return redirect()->back()->with('error', 'Failed to pull data from API.');
       }

       // echo $response;
    }
}
