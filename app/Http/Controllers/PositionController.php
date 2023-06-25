<?php

namespace App\Http\Controllers;

use App\Models\Position;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB; //untuk membuat query di controller
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

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
        
        if($request->input('page')){
            return view('admin.position.index',compact('title','position'));
        } else {
            return view('admin.position.search',compact('title','position'));
        }
     }
     

	## Tampilkan Form Create
    public function sync()
    {
       // Tarik data dari API
       $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_all_jabatan');

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

                   $position = Position::where('id',$item['jabatan_id'])->first();
                   if($position){
                       $position->id =  $item['jabatan_id'];
                       $position->name =  $item['NamaJabatan'];
                       $position->type =  $item['JenisJabatan'];
                       $position->save();
                   } else {
                       $position = New Position();
                       $position->id =  $item['jabatan_id'];
                       $position->name =  $item['NamaJabatan'];
                       $position->type =  $item['JenisJabatan'];
                       $position->save();
                   }
               }
           }

           activity()->log('Sinkronisasi Data Position');
           return redirect('/position')->with('status', 'Data Berhasil Disinkronisasi');
       } else {
           // return redirect()->back()->with('error', 'Failed to pull data from API.');
       }

       // echo $response;
    }
    
}
